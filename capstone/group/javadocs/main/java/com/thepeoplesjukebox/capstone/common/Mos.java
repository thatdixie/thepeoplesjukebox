package com.thepeoplesjukebox.capstone.common;
//
// Mos.java     Message Oriented Server Class
// ----------------------------------------------------------------------------
// History:
// --------
// 10/30/18 Dixie 	Initial creation.
// ----------------------------------------------------------------------------
//
import java.lang.*;
import java.text.*;
import java.util.Date;
import java.util.ArrayList;

//-----------------------------------------------------------------------------
// The Message Oriented Server (Mos) is a base class for a thread of execution. 
// A Mos thread blocks on a semaphore waiting for messages in it's queue. 
//
// Messages/objects are sent to Mos via the a sendMessage() method, which 
// enqueues  a MessageNode into the queue and signals the Mos semaphore.
// A MessageNode object may contain any object type, and thus SendMessage() 
// can send any object to a mos.
//
// MessageNodes also hold information about the message such as the Thread 
// reference of the calling object and the Date/Time of the created message. 
// In this way The Mos  message handler can always identify the originator 
// (by Name), and the creation time of an object passed to a Mos for processing.
//
// The abstract method  messageHandler() must be implemented to process 
// Mos Messages.
// ----------------------------------------------------------------------------
//
public abstract class Mos extends Thread
{
    private boolean     running =true;
    private Queue       msgQueue;
    private Semaphore   msgSema;
    private MessageNode currentMessageNode = null;
    public  String      myName;

    
    //--------------------------------------------------------------------------------
    // METHOD 	run()
    //
    // PURPOSE:	This the main execution loop for Mos.      
    //
    // INPUT:	None.
    //
    // PROCESS:	1) Block waiting for a MessageNode.
    // 		2) Invoke MessageHandler()
    //
    // RETURN:  Never.
    //--------------------------------------------------------------------------------
    public void run()
    {
	setName(myName);

        for( ;running; )
        {  
	    msgSema.pwait();
	    try
	    {
            	messageHandler(currentMessageNode = (MessageNode)msgQueue.dequeue()); 
	    }
	    catch(Exception e){}
         }   
    }


    //--------------------------------------------------------------------------------
    // METHOD 	sendMessage()
    //
    // PURPOSE:	Public method used to send a message/object to a Mos.
    //
    // INPUT:	Any Object.
    //
    // PROCESS:	1) Create Message Node.
    // 		2) Get current time and calling thread id.
    // 		3) Pack Message Node and post to message queue.
    //
    // RETURN:	None.
    //--------------------------------------------------------------------------------
    public void sendMessage(Object o)
    {
        MessageNode message = new MessageNode();	// Create a Message Node
	message.thread      = Thread.currentThread();	// Get calling thread
	message.timestamp   = new Date();		// Get current date/time
	message.object      = o;			// Get sending Message
        postMessage(message);				// Post node to queue
    }


    //--------------------------------------------------------------------------------
    // METHOD	postMessage()
    //
    // PURPOSE:	Post messages into message queue.
    //
    // INPUT:	MessageNode.
    //
    // PROCESS:	1) Enqueue message into queue
    //		2) Signal Mos.
    //          3) Bump message count
    //
    // RETURN:	None.
    //--------------------------------------------------------------------------------
    private void postMessage(MessageNode m)
    {
        msgQueue.enqueue(m);
        msgSema.signal();
    }


    //--------------------------------------------------------------------------------
    // METHOD	getMessageCount()
    //
    // PURPOSE:	Return the current Message count.
    //
    // INPUT:	None.
    //
    // PROCESS:	None.
    //
    // RETURN:	msgQueue.Count()
    //--------------------------------------------------------------------------------
    public int getMessageCount()
    {
        return(msgQueue.count());
    }


    //--------------------------------------------------------------------------------
    // METHOD	dump()
    //
    // PURPOSE:	Return an ArrayList of MessageNodes currently in Queue.
    //
    // INPUT:	None.
    //
    // PROCESS:	None.
    //
    // RETURN:	msgQueue.dumpQueue()
    //--------------------------------------------------------------------------------
    public ArrayList dump()
    {
        return(msgQueue.dumpQueue());
    }

    //--------------------------------------------------------------------------------
    // METHOD	MessageHandler()
    //
    // PURPOSE: Abstract method invoked by run() to process Mos Message Nodes.
    //
    // INPUT:	MessageNode.
    //
    // PROCESS:	Abstract.
    //
    // RETURN:	None.
    //--------------------------------------------------------------------------------
    public abstract void messageHandler(MessageNode m);


    //--------------------------------------------------------------------------------
    // METHOD stop()
    //
    // PURPOSE:	terminate thread.
    //
    //--------------------------------------------------------------------------------
    public void stopRunning()
    {
        running = false;
	msgSema.signal();
    }

    
    //--------------------------------------------------------------------------------
    // METHOD Mos()
    //
    // PURPOSE:	Mos constructor.   
    //
    // INPUT:	Name of Mos instance.
    // 		Referance to sharedObjects.
    //
    // PROCESS:	Create message queue and Semaphore objects...set myName
    //
    // RETURN:	None.
    //--------------------------------------------------------------------------------
    public Mos(String name)
    {
        msgQueue = new Queue();
        msgSema  = new Semaphore(0);
        myName   = name;
	running  = true;
    }
}
