# Git学习总结

## 一、git来源历史回溯
​        很多人都知道，Linus在1991年创建了开源的Linux，从此，Linux系统不断发展，已经成为最大的服务器系统软件了。

​      	Linus虽然创建了Linux，但Linux的壮大是靠全世界热心的志愿者参与的，这么多人在世界各地为Linux编写代码，那Linux的代码是如何管理的呢？

​	事实是，在2002年以前，世界各地的志愿者把源代码文件通过diff的方式发给Linus，然后由Linus本人通过手工方式合并代码！

​	你也许会想，为什么Linus不把Linux代码放到版本控制系统里呢？不是有CVS、SVN这些免费的版本控制系统吗？因为Linus坚定地反对CVS和SVN，这些集中式的版本控制系统不但速度慢，而且必须联网才能使用。有一些商用的版本控制系统，虽然比CVS、SVN好用，但那是付费的，和Linux的开源精神不符。

​	不过，到了2002年，Linux系统已经发展了十年了，代码库之大让Linus很难继续通过手工方式管理了，社区的弟兄们也对这种方式表达了强烈不满，于是Linus选择了一个商业的版本控制系统BitKeeper，BitKeeper的东家BitMover公司出于人道主义精神，授权Linux社区免费使用这个版本控制系统。

​	安定团结的大好局面在2005年就被打破了，原因是Linux社区牛人聚集，不免沾染了一些梁山好汉的江湖习气。开发Samba的Andrew试图破解BitKeeper的协议（这么干的其实也不只他一个），被BitMover公司发现了（监控工作做得不错！），于是BitMover公司怒了，要收回Linux社区的免费使用权。

​	Linus可以向BitMover公司道个歉，保证以后严格管教弟兄们，嗯，这是不可能的。实际情况是这样的：

Linus花了两周时间自己用C写了一个分布式版本控制系统，这就是Git！一个月之内，Linux系统的源码已经由Git管理了！牛是怎么定义的呢？大家可以体会一下。

​	Git迅速成为最流行的分布式版本控制系统，尤其是2008年，GitHub网站上线了，它为开源项目免费提供Git存储，无数开源项目开始迁移至GitHub，包括jQuery，PHP，Ruby等等。

​	历史就是这么偶然，如果不是当年BitMover公司威胁Linux社区，可能现在我们就没有免费而超级好用的Git了。

## 二、git vs SVN
- git为分布式 vs svn集中式
- git不存在中央服务器，每个人的电脑上都是一个完整的版本库，不需要联网也可以进行版本控制；svn必须联网，适合局域网
- git安全性高，即使个人电脑损坏也不会丢失代码。 svn中央服务器损坏可能会导致代码丢失
- git目前为最快、最简单、最流行的版本控制器

## 三、git的安装
- mac App Store xcode已集成git

## 四、git的使用
### 4.1 常用命令
1.创建respository   	 ```git init```

2.添加文件到暂存区   	```git add [fileName]```

3.提交文件     	   ```git commit -m"xxxxxxx" [fileName] //相当于保存一个快照```

4.查看文件状态    ```git status```

5.对比文件        ```git diff [fileName]```

6.查看历史        ```git log [--pretty=oneline]```

7.版本回退        ```git reset --hard [HEAD^|HEAD^^|HEAD^^^|HEAD~100|82egc85]``` //git版本回退仅仅是HEAD指针的移动，速度非常快

8.git add前撤销修改        ```git checkout --fileName``` 

9.git add后撤销修改      ```git reset HEAD [file]```

10.切换分支 ```git checkout [master|dev]```

11.创建并切换分支 ```git checkout -b dev```

12.删除文件   ```git rm fileName```

13.误删后恢复  ```git checkout fileName```

14.关联远程库  ```git remote add origin git@github.com:LiuweiGhub/myRespository.git```

15.推送内容到远程库 ```git push [-u] origin master```

16.拉取远程库更新  ```git pull [origin master]```

17.克隆    ```git clone "xxxxx"```

18.查看分支  ```git branch```

19.查看远程分支 ```git remote -v ```

20.合并分支  ```git merge --no-ff -m"merge from ...." dev``` 

21.临时存储 ```git stash```

22.查看存储的代码 ```git stash list```

23.恢复存储 ```git stash apply  ||  git stash pop```

24.删除存储 ```git stash drop```

25.删除分支  ```git branch -d dev```

26.强行删除分支 ```git branch -D feature```

27.打标签    ```git tag <name> || git tag -a v0.1 -m"version 1.0 released" 1094ab```

28.查看状态  ```git tag```

29.查看标签信息  ```git show <tagName>```

30.删除标签  ```git tag -d v1.0```

