# Modern Yaf

Use Yaf modern way

---

### 类的加载

使用命名空间（namespace）与包管理（composer）

#### 基类及一些库

放在 `app/library` 下，如 `Model.php`

#### controller 类的加载：

Yaf 会根据uri来进行判断，如果uri是 `模块/控制器/操作` 即我们说的分组的情况下, 则在 `app/modules/module-name/controllers/` 文件夹下查找；
如果只有两段，则会在 `app/controllers/`文件夹下查找

#### model 类的加载：

Yaf 调用 `new xxxModel();` 是在`app/models/` 文件夹下寻找`xxx.php`类文件的，框架中也依然保留，同时为了结构化、条理性，在 `app/modules/module-name`下新建了`models`文件夹，同时在 `Bootstrap.php` 中注册了`app/modules/module-name/models`文件夹下的类的自动加载规则，这里的 **module-name **是根据`Yaf\Application::app()->getRequest()->getRequestUri()`的 **uri** 来做处理的，详细见代码。
`module-name/models` 下的类文件并不遵循 Yaf Model 类的命名规则，有自己的灵活性。开发中我们一般的操作可能是：
- 在 `module-name/models`下创建 `Abc` model 类，文件名是 `Abc.php`
- model Abc 继承 `Model.php` 基类

像：

```php
<?php
# 注意，是Abc，而不是 AbcModel, 如果是AbcModel,加载的则是 app/models 下的类
class Abc extends Model 
{
    # properties & methods
}
```

- 在 controller 中实例化

像:

```php
<?php
    ...

    $Abc = new Abc();
    $Abc->method_name();

    ...

```

>问：如果`module-name/models`下的类与`app/library`下的冲突怎么办？

>答：按照 spl_autoload 的机制，先找到谁就先调用谁。由于 yaf 的 `app/library`下的类先于我们在注册，所以一般情况下调用的是 `app/library`中的类；一般情况下我们也遵从这样的安排。当然，如必要，这也是可以调整的，详见 `spl_autoload_register` 方法的第三个参数 `prepend`，为真时，表示将我们将要注册的自动加载方法前置，就实现了与上述相反的情况。
