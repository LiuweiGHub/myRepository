import java.util.*;
//类名Test，所以文件名必须是Test.java
//编译文件：javac Test.java, 生成Test.class
//执行类：java Test Test.class
public class Test{
    public static void main(String[] args) {
        List<String> list = new ArrayList<String>();
        list.add("Hello");
        list.add("World");
        list.add("HAHAHAHA");
        //第一种遍历方法：使用foreach遍历List
        for (String str : list)
        {
            System.out.println(str);
        }
        //第二种遍历方法：把链表变为数组相关的内容进行遍历
        String[] strArray = new String[list.size()];
        list.toArray(strArray);
        for(int i=0;i<strArray.length;i++)
        {
            System.out.println(strArray[i]);
        }
        //第三种遍历 使用迭代器进行相关遍历
        //迭代器方法不用担心在遍历的过程中会超出集合的长度
        Iterator<String> ite = list.iterator();
        while(ite.hasNext())
        {
            System.out.println(ite.next());
        }
    }
}
