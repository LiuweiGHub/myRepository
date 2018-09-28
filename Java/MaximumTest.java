/**
 * 有界的类型参数：
 * 即限制被允许传递到一个类型参数的类型种类范围
 * 要声明一个有界的类型参数，首先列出类型参数的名称，后跟extends关键字，最后紧跟它的上界
 */
public class MaximumTest
{
    // 比较三个值并返回最大值
    public static <T extends Comparable<T>> T maximum(T x, T y, T z)
    {
        T max = x; //假设x是初始最大值
        if (y.compareTo(max) > 0)
        {
            max = y;
        }
        if (z.compareTo(max) > 0)
        {
            max = z;
        }
        return max;
    }

    public static void main(String args[])
    {
        System.out.printf("%d, %d 和 %d 中的最大数为 %d\n\n", 3, 4, 5, maximum(3, 4, 5));

        System.out.printf("%.1f, %.1f 和 %.1f 中最大的数为 %.1f\n\n", 6.6, 8.8, 7.7, maximum(6.6, 8.8, 7.7));

        System.out.printf("%s, %s 和 %s 中最大的数为 %s\n","pear", "apple", "orange", maximum("pear", "apple", "orange"));
    }
        
    
}