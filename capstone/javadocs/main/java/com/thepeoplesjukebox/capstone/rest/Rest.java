package com.thepeoplesjukebox.capstone.rest;

import com.thepeoplesjukebox.capstone.common.DixieHash;

import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Iterator;
import java.util.Map;
import java.util.Set;

/**
 * Rest object performs all http/rest functions 
 * for TPJ and capstone API's 
 *
 * @author  Dixie
 */
public class Rest extends Object
{
    private String url  ="";
    private String auth ="";

    //-----------------------------
    // Get/Set functions
    //-----------------------------
    public void setUrl(String u)
    {
	url = u;
    }
    public String getUrl()
    {
	return(url);
    }
    public void setAuth(String a)
    {
	auth = a;
    }
    public String getAuth()
    {
	return(auth);
    }
        
   /**
    * post request 
    *
    * @param  api_function
    * @param  params
    */
    public String post(String api_function, DixieHash params)
    {
        try
		{
			String url = this.getUrl()+api_function;
			URL obj    = new URL(url);
			HttpURLConnection con = (HttpURLConnection) obj.openConnection();

	        con.setRequestMethod("POST");
	        con.setRequestProperty("User-Agent","Java/1.8");
	        con.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
            if(!this.getAuth().equals(""))
	            con.setRequestProperty("Authorization", this.getAuth());
 
	        String urlParameters = "";
	        Set set = params.entrySet();
	        Iterator it = set.iterator();
	        while (it.hasNext())
	        {
	            Map.Entry entry = (Map.Entry) it.next();
                urlParameters = urlParameters+entry.getKey()+
                        "="+entry.getValue()+"&";
	        }
            //Log.e("rest",urlParameters);
	        con.setDoOutput(true);
	        DataOutputStream wr = new DataOutputStream(con.getOutputStream());
	        wr.writeBytes(urlParameters);
	        wr.flush();
	        wr.close();

	        int responseCode  = con.getResponseCode();
	        BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
	        String inputLine;
	        StringBuffer response = new StringBuffer();

	        while ((inputLine = in.readLine()) != null)
	       {
	            response.append(inputLine);
	       }
	        in.close();
	
	        return(response.toString());
	    }
	    catch(Exception e)
	    {
	        return("{\"errorCode\":\"500\", \"errorMessage\":\"REST Server Error\"}");
	    }
    }

    
   /**
    * get request 
    *
    * @param  api_function
    * @param  params
    */
    public String get(String api_function, DixieHash params)
    {
        try
        {
	        String url =getUrl()+api_function;
	        String urlParameters ="?";
	        Set set = params.entrySet();
	        Iterator it = set.iterator();
	        while (it.hasNext())
	        {
	            Map.Entry entry = (Map.Entry) it.next();
	            urlParameters = urlParameters+entry.getKey()+
                        "="+entry.getValue()+"&";
	        }
	        url = url+urlParameters;
            URL obj = new URL(url);
            //Log.e("rest",url);
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();

            con.setRequestMethod("GET");
            con.setRequestProperty("User-Agent", "Java/1.8");
            if(this.getAuth() != "")
	            con.setRequestProperty("Authorization", this.getAuth());

            int responseCode = con.getResponseCode();
            BufferedReader in = new BufferedReader( new InputStreamReader(con.getInputStream()));
            String inputLine;
            StringBuffer response = new StringBuffer();

            while ((inputLine = in.readLine()) != null)
            {
                response.append(inputLine);
            }
            in.close();
	
            return(response.toString());
	    }
	    catch(Exception e)
	    {
	        return("{\"errorCode\":\"500\", \"errorMessage\":\"REST Server Error\"}");
	    }
    }

    /**
     * getDatabytes -- called to to get non-REST functions that return raw data
     *
     * @param  api_function
     * @param  params
     */
    public byte[] getDataBytes(String api_function, DixieHash params)
    {
        try
        {
            String url =getUrl()+api_function;
            String urlParameters ="?";
            Set set = params.entrySet();
            Iterator it = set.iterator();
            while (it.hasNext())
            {
                Map.Entry entry = (Map.Entry) it.next();
                urlParameters = urlParameters+entry.getKey()+"="+entry.getValue()+"&";
            }
            url = url+urlParameters;
            URL obj = new URL(url);
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();

            con.setRequestMethod("GET");
            con.setRequestProperty("User-Agent", "Java/1.8");
            if(!this.getAuth().equals(""))
                con.setRequestProperty("Authorization", this.getAuth());

            int responseCode = con.getResponseCode();

            InputStream in = con.getInputStream();
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            int reads = in.read();
            while(reads != -1){
                baos.write(reads);
                reads = in.read();
            }
            return(baos.toByteArray());
        }
        catch(Exception e)
        {
            return(null);
        }
    }

    
    public Rest(String u)
    {
	    url = u;
	    auth="";
    }

    public Rest(String u, String a)
    {
	    url = u;
	    auth= a;
    }

    public Rest()
    {
	    url ="";
	    auth="";
    }
}
