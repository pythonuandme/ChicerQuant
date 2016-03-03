/**
 * 
 */
package AnyQuantProject.util.method;


import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import org.python.antlr.PythonParser.return_stmt_return;

/**
 * @author G
 *
 */
public class CalendarHelper {
	/**
	 * 将calendar对象转换成yyyy-MM-dd格式的string
	 * 迷之-mm-出错
	 * @param date
	 * @return
	 */
	public static String getDate(Calendar date){
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
		return sdf.format(date.getTime());
	}
	
	/**
	 * 得到所给日期的前一天
	 * @param date
	 * @return
	 */
	public static Calendar getPreviousDay(Calendar date){
		Calendar result = getNeighborDay(date, -1);
		return result;
	}
	
	/**
	 * 得到所给日期的后一天
	 * @param date
	 * @return
	 */
	public static Calendar getAfterDay(Calendar date) {
		Calendar result = getNeighborDay(date, 1);
		return result;
	}
	
	
	/**
	 * 得到与指定日期相隔任意天的日期
	 * @param date
	 * @param num
	 * @return
	 */
	//！！！啊啊啊，终于成功了，date不能直接赋值给result，否则会捆绑，有函数副作用，坑！！
	private static Calendar getNeighborDay(Calendar date, int num) {
		Calendar result = Calendar.getInstance();
		result.set(Calendar.YEAR, date.get(Calendar.YEAR));
		result.set(Calendar.MONTH, date.get(Calendar.MONTH));
		result.set(Calendar.DAY_OF_MONTH, date.get(Calendar.DAY_OF_MONTH));
		result.add(Calendar.DAY_OF_MONTH, num);
		return result;
	}
	
	//tested --success
	public static void main(String[] args) {
//		Calendar c = Calendar.getInstance();
//		
//		System.out.println(CalendarHelper.getDate(c));
//		System.out.println(CalendarHelper.getDate(CalendarHelper.getPreviousDay(c)));
//		System.out.println(CalendarHelper.getDate(CalendarHelper.getAfterDay(c)));
//		CalendarHelper.getPreviousDay(c);
//		System.out.println(CalendarHelper.getDate(c));
//		CalendarHelper.getAfterDay(c);
//		System.out.println(CalendarHelper.getDate(c));
	}
}
