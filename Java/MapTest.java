import java.util.*;

public class MapTest
{
    public static void main(String[] args)
    {
        //String 必须使用双引号？ 为什么？
        Map<String, String> map = new HashMap<String, String>();
        map.put("1", "陈咬金");
        map.put("2", "孙悟空");
        map.put("3", "孙尚香");

        //第一种：普遍使用，二次取值
        System.out.println("通过Map.keySet遍历key和value：");
        for (String key : map.keySet())
        {
            System.out.println("key= "+ key + " and value= " + map.get(key));
        }
        //第二种
        System.out.println("通过Map.entrySet使用iterator遍历key和value");
        Iterator<Map.Entry<String, String>> it = map.entrySet().iterator();
        while(it.hasNext())
        {
            Map.Entry<String, String> entry = it.next();
            System.out.println("key= " + entry.getKey() + " and value = " + entry.getValue());
        }

        //第三种：推荐，尤其是容量大时
        System.out.println("通过Map.entrySet遍历key和value");
        for (Map.Entry<String, String> entry : map.entrySet())
        {
            System.out.println("key = " + entry.getKey() + " and value = " + entry.getValue());
        }

        //第四种
        System.out.println("通过Map.values()遍历所有values,但不能遍历key");
        for(String v : map.values())
        {
            System.out.println("values = " + v);
        }

    }
}