public class GenericsTest
{
    //泛型方法
    public static < E > void printArray( E[] inputArray )
    {
        //输出数组元素
        for ( E element : inputArray )
        {
            System.out.printf("%s ", element );
        }
        System.out.println();
    }

    public static void main( String args[] )
    {
        //创建不同类型数组：Integer、Double、Character
        Integer[] intArray = {1,2,3,4,5};
        Double[] doubleArray = { 1.1, 1.2, 1.3, 1.5};
        Character[] charArray = {'H','E','L','L','O'};

        System.out.println("整型数组元素为：");
        printArray( intArray );

        System.out.println("\n双精度型数组元素为：");
        printArray(doubleArray);

        System.out.println("\n字符型数组元素为：");
        printArray(charArray);
    }
}