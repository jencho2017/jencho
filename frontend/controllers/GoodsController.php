<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 23:48
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Cart;
use frontend\models\Address;
use frontend\models\Member;
use frontend\models\Order;
use frontend\models\OrderDetail;
use frontend\widgets\GoodsDetailWidget;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Request;

class GoodsController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'address';

    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=>['order'],
                'rules'=>[
                    [
                        'allow'=>true,
                        'actions'=>['order'],
                        'roles'=>['@'],
                    ]
                ],
            ],
        ];
    }
    public function actionDetail()
    {
        return $this->render('detail');
    }
    public function actionList()
    {
        return GoodsDetailWidget::widget();
    }

    public function actionXiangqing()
    {
        $this->layout = 'address';
        $goods_id = \Yii::$app->request->get('goods_id');
        $model = Goods::findOne(['id'=>$goods_id]);
        return $this->render('xiangqing',['model'=>$model]);
    }

    /**
     * 加入购物车
     * 点击加入购物车
     */
    public function actionTakein()
    {
        $this->layout = 'login';
        //获取商品Id和数量
        $goods_id=$_POST['goods_id'];
        $num=$_POST['amount'];
        //将商品id和数量保存到cookie中
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            //判断购物车中是否有前台的商品
            if($cookies->get('cart')==null){
                $data=[];
            }else{
                $data=unserialize($cookies->get('cart'));
            }
            if(array_key_exists($goods_id,$data)){
                //2 购物车已经有该商品  数量累加
                $data[$goods_id] += $num;
            }else{
                //1 购物车没有该商品   直接添加到数组
                $data[$goods_id] = $num;
            }
            $cookies=\Yii::$app->response->cookies;
            $cookie=new Cookie(['name'=>'cart','value'=>serialize($data)]);
            $cookies->add($cookie)             ;
        }else{
            //1 检查购物车有没有该商品(根据goods_id member_id查询)
            $user_id = \Yii::$app->user->id;
            $cart = new Cart();
            $res =Cart::find()->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->One();
            //1.1 有该商品  数量累加
            if($res){
                $res->amount += $num;
                $res->update();
            }else{
                $cart->user_id = $user_id;
                $cart->goods_id = $goods_id;
                $cart->amount = $num;
                $cart->save();
            }
            //1.2 没有该商品  添加到数据表
        }

        //跳转到购物车页面
        return $this->redirect(['goods/cart']);
    }

    //购物车结算
    public function actionCart()
    {
        if(\Yii::$app->user->isGuest){
            //将商品id和数量从cookie取出
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){//购物车cookie不存在
                $cart = [];
            }else{//购物车cookie存在
                $cart = unserialize($cookie->value);
            }
        }else{
            //用户已登录，从数据表获取购物车数据
            $cart = [];
            $goods =Cart ::find()->where(['user_id'=>\Yii::$app->user->id])->all();
            foreach($goods as $good){
                $cart[$good->goods_id]=$good->amount;
            }
        }
        $models = [];
        //循环获取商品数据，构造购物车需要的格式
        foreach($cart as $id=>$num){
            $goods = Goods::find()->where(['id'=>$id])->asArray()->one();
            $goods['num']=$num;
            $models[]=$goods;
        }
        return $this->render('cart',['models'=>$models]);
    }

    //订单
    public function actionOrder()
    {
        $this->layout = 'address';
        $order = new Order();
        $request = new Request();
        if($request->isPost){
            //收货地址
            $address = Address::findOne(['id'=>\Yii::$app->request->post('address_id')]);
            $order->name = $address->username;
            $order->member_id = \Yii::$app->user->id;
            $order->province_name = $address->province;
            $order->city_name = $address->city;
            $order->area_name = $address->area;
            $order->detail_address = $address->detail;
            $order->tel = $address->tel;
            //配送方式
            $send_id = \Yii::$app->request->post('send_id');
            $order->delivery_id = $send_id;
            $order->delivery_name = Order::$deliveries[$send_id][0];
            $order->delivery_price = Order::$deliveries[$send_id][1];
            //支付方式
            $pay_id = \Yii::$app->request->post('pay_id');
            $order->pay_type_id = $pay_id;
            $order->pay_type_name = Order::$payments[$pay_id][0];
            //总金额
            $money = [];
            $goodss = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
            foreach($goodss as $goods){
                $goodsprice = Goods::findOne(['id'=>$goods->goods_id]);
                $money[] = ($goodsprice->shop_price * $goods->amount);
            }
            $order->price =array_sum($money);
            //订单状态
            if($order->pay_type_id == 1){
                $order->status = 0;//0待发货
            }else{
                $order->status = 1;//1待支付
            }
            //订单创建时间
            $order->create_time = time();
            //保存订单前开启事务,保持数据安全性
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();//开启事务
        try{
               //保存订单
               $order->save();
               //订单详情
                //循环购物车,循环一次生成个订单详情
                $order_detail = new OrderDetail();
                $carts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
                foreach($carts as $cart){
                    $order_detail->order_info_id = $order->id;
                    $order_detail->goods_id = $cart->goods_id;
                    $god = Goods::findOne(['id'=>$cart->goods_id]);
                    $order_detail->goods_name = $god->name;
                    $order_detail->logo = $god->logo;
                    $order_detail->amount = $cart->amount;
                    $order_detail->price = $god->shop_price;
                    $order_detail->total_price = $order_detail->price * $order_detail->amount;
                    if($order_detail->amount > $god->stock){
                        throw new Exception($god->name.'的库存不足!');
                    }
                    $order_detail->save();
                    $transaction->commit();
                }
            }catch (Exception $e){
                $transaction->rollBack();
                \Yii::$app->session->setFlash('danger','商品库存不足!');
            }
            return $this->render('ok');
        }
        //查询订单所需数据
        //根据id查询当前用户的收货地址信息
        $addresss = Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        //支付方式
        $pays = Order::$payments;
        //送货方式
        $sends = Order::$deliveries;
        //商品清单
        $carts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        $goodss = [];
        foreach($carts as $cart){
            $goods_id = $cart->goods_id;
            $goods_count = $cart->amount;
            $goodss[] = Goods::findOne(['id'=>$goods_id]);
            foreach($goodss as $goods){
                if($goods->count==false){
                    $goods->count = $goods_count;
                }
            }
        };
        //查询end
        return $this->render('order',['addresss'=>$addresss,'pays'=>$pays,'sends'=>$sends,'goodss'=>$goodss]);
    }
    //生成订单
    public function actionCreaeorder()
    {
        //订单也传商品id 收货地址id 配送方式id  支付方式id
        $carts = \Yii::$app->request->post();

    }
}