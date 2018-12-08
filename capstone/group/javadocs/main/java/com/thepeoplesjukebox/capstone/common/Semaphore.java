package com.thepeoplesjukebox.capstone.common;
//
// Semaphore.java	    Semaphore class (P & V operations )
// ----------------------------------------------------------------------------
// History:
// --------
// 10/30/18 Dixie    Initial creation.
// ----------------------------------------------------------------------------
//

public class Semaphore
{
    private int count;
    private int threads_waiting;

    //-----------------------------------------
    // Semephore 'P' operation.
    //-----------------------------------------
    public synchronized void pwait()
    {
        while(count ==0)
        {
	        threads_waiting++;
		try
	        {
	            this.wait();
		}
		catch (Exception e) {}
	        
	        threads_waiting--;
        }
        count--;
    }
  
    //-----------------------------------------
    // Semephore 'V' operation.
    //-----------------------------------------
      public synchronized void signal()
    {
        if(threads_waiting != 0)
	        this.notify();
        count++;
    }


    public Semaphore(int c)
    {
        threads_waiting =0;
        count = c;
    }    
}
