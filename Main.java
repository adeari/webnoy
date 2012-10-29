public class Main {

    /**
     * @param args the command line arguments
     */
    public static boolean debugginfg=false;
    public static String getPath()
    {
        
        String balik="",path=""; 
        boolean windows=false;
        java.util.StringTokenizer stk12=new java.util.StringTokenizer(System.getProperty("java.class.path"),"\\");
        if (stk12.countTokens()>1)
            windows=true;
        else
        {
            stk12=new java.util.StringTokenizer(System.getProperty("user.dir"),"\\");
            if (stk12.countTokens()>1)
                windows=true;
        }
        if (windows) //untuk windows
        {
            
           path=System.getProperty("java.class.path");
           int panjang=path.length(),i=0;
           boolean adatitikkoma=false;
           String sementara="";
           i=0;
          
           while (i<panjang&&!adatitikkoma)
           {
               sementara=path.substring(i,(i+1));
               if (sementara.equalsIgnoreCase(":"))
                   adatitikkoma=true;
               i++;
           }
           if (!adatitikkoma)
           {
               path=System.getProperty("user.dir")+"\\"+path;
               
           }
           java.util.StringTokenizer stk=new java.util.StringTokenizer(path,"\\");
           path="";
           panjang=stk.countTokens();
           for (i=0;i<panjang-1;i++)
           {
                if (stk.hasMoreTokens())
                path+=stk.nextToken()+"/";
           }
           balik=path;
        }
        else  //untuk linux
        {
        try{
           path=System.getProperty("java.class.path");
           String pathSeleksi=path;           
           java.util.StringTokenizer stk=new java.util.StringTokenizer(path,"/");
           if (path.substring(0,1).equalsIgnoreCase("/"))
               path="/";
           else
               path=System.getProperty("user.dir")+"/";
           int i=0;           
           int panjang=stk.countTokens();
           for (i=1;i<panjang;i++)
           {
               if (stk.hasMoreTokens())
                   path+=stk.nextToken()+"/";  
           }
           java.io.File fl=new java.io.File(pathSeleksi);
           if (!fl.isFile())
               path=System.getProperty("user.dir")+"/"+path;
           balik=path;
        }
        catch (Exception e){}        
        }
        return balik;
    }
    
    public static java.sql.Connection konek()
    {
        java.sql.Connection koneksinya=null;
        boolean cekfile=true;
        String manager="";
        try{
            Class.forName("org.gjt.mm.mysql.Driver");
            manager="jdbc:mysql://localhost/webnoy";
            koneksinya=java.sql.DriverManager.getConnection(manager,"root","webnonoy");
        }
        catch (Exception w){}
        return koneksinya;
    }

	public static String kodelah(String uang)
	{
		String balik="";
		if (uang.equalsIgnoreCase("1"))
			balik="X";
		else if (uang.equalsIgnoreCase("2"))
			balik="Z";
		else if (uang.equalsIgnoreCase("3"))
			balik="E";
		else if (uang.equalsIgnoreCase("4"))
			balik="A";
		else if (uang.equalsIgnoreCase("5"))
			balik="S";
		else if (uang.equalsIgnoreCase("6"))
			balik="G";
		else if (uang.equalsIgnoreCase("7"))
			balik="T";
		else if (uang.equalsIgnoreCase("8"))
			balik="B";
		else if (uang.equalsIgnoreCase("9"))
			balik="R";
		return  balik;
	}

	public static String ubahkode(String uang)
	{
		String balik="",karakter="";
		boolean ada0=true;
		int jmluang=uang.length();
		int i=0,lanjut=0,itung=0;;
		while (i<jmluang)
		{
			karakter=uang.substring(i,(i+1));
			if (debugginfg)
				System.out.println(karakter);
			if (karakter.equalsIgnoreCase("0"))
			{
				ada0=true;
				lanjut=i+1;
				itung=1;
				while (ada0&&lanjut<jmluang)
				{
					karakter=uang.substring(lanjut,(lanjut+1));
					if (debugginfg)
						System.out.println(karakter);
					if (karakter.equalsIgnoreCase("0"))
					{
						i=lanjut;lanjut++;itung++;
					} else ada0=false;
					if (itung==1) balik+="C";
					else balik+=String.valueOf(itung);
					if (debugginfg)
						System.out.println(balik);
				}
			}
			else balik+=kodelah(karakter);
			if (debugginfg)
				System.out.println(balik);
			i++;
		}
		return balik;
	}

    
    public static void main(String[] args) {
String jenisReport=args[0];
String FilePDF=args[1];
String fileName=getPath()+"rpStokbarang.jasper";
java.sql.Connection konek=konek();
        
java.util.Map parameter=new java.util.HashMap();

        

        try{

//untuk stok barang tabel

//java Main stokbarangtabel stokBarang01012003004739o.pdf 2 44463 ctmtx25-9012

if (jenisReport.equalsIgnoreCase("stokbarangtabel"))
{
	fileName=getPath()+"rpStokbarang.jasper";
	String jumlah=args[2];
	int jmlBarang=Integer.valueOf(jumlah).intValue()+2;
	int i=0;
	String kondisi="where ";
	for (i=3;i<=jmlBarang;i++ )
	{
		if (i==3)	kondisi+=" kd_brg='"+args[i]+"' ";
		else kondisi+=" or kd_brg='"+args[i]+"' ";
	}
	parameter.put("kondisi",kondisi);
	String querynya="select kd_brg,hrg_beli from tb_barang "+kondisi;
	java.sql.Statement sta=konek.createStatement();
	java.sql.Statement sta1=konek.createStatement();
    java.sql.ResultSet rs=sta.executeQuery(querynya);
	querynya="";
	while (rs.next()) {
		querynya="update tb_barang set kd_hrgbeli='"+ubahkode(rs.getString("hrg_beli"))+"' where kd_brg='"+rs.getString("kd_brg")+"';";
		if (debugginfg)
			System.out.println(querynya);
		sta1.executeUpdate(querynya);
	}
	querynya="select format(sum(stok*hrg_beli),0) as total from tb_barang "+kondisi;
	rs=sta.executeQuery(querynya);
	if (rs.next())
		parameter.put("jml",rs.getString("total"));
	else
		parameter.put("jml","0");
	
	rs.close();
	sta.close();
	sta1.close();
}

//----------------end untuk stok barang tabel

        net.sf.jasperreports.engine.JasperPrint  jasperPrint=net.sf.jasperreports.engine.JasperFillManager.fillReport(fileName,parameter,konek);
		//buat bikin pdf file
		net.sf.jasperreports.engine.JasperExportManager.exportReportToPdfFile(jasperPrint,FilePDF);
		//buat print
        //net.sf.jasperreports.engine.JasperPrintManager.printReport(jasperPrint,false);
		/*
        net.sf.jasperreports.view.JasperViewer jasperViewer=new net.sf.jasperreports.view.JasperViewer(jasperPrint,false);
        jasperViewer.setDefaultCloseOperation(javax.swing.JFrame.HIDE_ON_CLOSE);
        jasperViewer.setExtendedState(javax.swing.JFrame.MAXIMIZED_BOTH);
        jasperViewer.setTitle("Laporan");
        jasperViewer.setVisible(true);
		*/

konek.close();		
        }
        catch (Exception w){System.out.println(" salah "+w.getMessage());}

    }

}
