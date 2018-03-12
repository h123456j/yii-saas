## yii-saas
基于yii2框架下使用bootstrap集成api接口，接口在线文档，管理后台与前台的saas项目

### 目录结构说明
--- assets --资源文件管理器   
&emsp;--- admin --后台模块资源文件管理   
&emsp;--- api --api在线文档模块  
&emsp;--- common --公共资源文件管理   
&emsp;--- frontend -- 前台模块   
--- common --公共代码目录   
&emsp;--- core --核心公共类   
&emsp;--- error --错误处理      
&emsp;--- helpers --帮助类   
&emsp;--- widgets --组件   
--- component --组件模块   
&emsp;--- controller --基类控制器      
&emsp;--- exception --异常处理      
&emsp;--- filter --过滤器   
&emsp;--- helpers --帮助类   
&emsp;--- http --网络请求   
&emsp;--- models --model基类   
&emsp;--- service --服务基类   
&emsp;--- session --会话控制   
&emsp;--- widgets --前台组件   
--- config --全局配置模块   
&emsp;---admin --管理后台配置   
&emsp;---api --api模块配置   
&emsp;---frontend --前台配置模块      
--- doc  --文档相关【sal文件】   
--- models  -- 数据表models   
--- modules -- 模块目录    
&emsp;--- admin --管理后台   
&emsp;--- api --接口     
&emsp;--- doc --在线接口文档    
&emsp;--- frontend --前台   
--- services --服务      
--- web 
&emsp;--- static    
&emsp;--- uploads  

### 前台主页面【页面样式目前没开发，访问地址：{host}】
 ![前台主页](https://github.com/h123456j/yii-saas/blob/master/web/static/readme/frontend-1.png)

### 在线接口文档模块【访问地址：{host}/api】
使用php反射API将API模块下控制器与方法的注释生成对应的api文档
 
 #### 在线接口文档主页
 
 ![在线接口文档主页](https://github.com/h123456j/yii-saas/blob/master/web/static/readme/api-2.png)
 
### 控制器层配置模板
```
<?php
/**
 * Class User
 * @package api\controllers
 * @controller-name 用户模块 --模块名称
 * @controller-rank 20 --模块排序权重【权重越大，在接口文档页面排序越前】
 */
class UserController extends BaseController
{
}
?>
```
#### action方法层注释模板
```
<?php 
 /**
     * @api-name  微信授权登录 --接口名称
     * @api-url user/we-chat-login --接口地址
     * @api-method POST --请求方式
     * @api-param string $code 微信授权登录code --请求参数
     * @api-response {  --返回数据
     *    "data":{
     *      "completeInfo": true,用户信息是否已完善(true-是 false-否)
     *      "uid": "15081455574753",用户id
     *      "sid": "31a569fbbe31a85561f1ede3f6bc750a",会话id
     *        }
     * }
     */
    public function actionWeChatLogin()
    {
    }
?>
```
#### 接口文档模块会自动渲染api【可通过参数控制】模块下的控制器，遍历各控制器下的方法，实时生成对应的接口文档，生产环境可以将改模块禁止访问
#### 显示效果如下
![在线接口文档主页](https://github.com/h123456j/yii-saas/blob/master/web/static/readme/api-1.png)

### 管理后台模块【访问地址{host}/admin】
#### 管理员登录界面
![管理员登录](https://github.com/h123456j/yii-saas/blob/master/web/static/readme/login-1.png)

#### 管理后台主页
![管理后台主页](https://github.com/h123456j/yii-saas/blob/master/web/static/readme/admin-1.png)

#### 系统设置页面-导航栏
![系统设置页面-导航栏](https://github.com/h123456j/yii-saas/blob/master/web/static/readme/admin-2.png)

#### 新增导航栏
![新增导航栏](https://github.com/h123456j/yii-saas/blob/master/web/static/readme/admin-3.png)


#### 文档就饿描述到这了，欢迎指正，有疑问可以咨询qq：513553191
