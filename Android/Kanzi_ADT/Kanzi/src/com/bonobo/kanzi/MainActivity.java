package com.bonobo.kanzi;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;

/**
 * This is the Main Activity for Navigating to the WEBVIEW Activity
 * 
 * @author Administrator
 *
 */
public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
    	
    	final Context context = this;
    	
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        // Call the WebViewActivity on load
        Intent intent = new Intent(context, WebViewActivity.class);
		startActivity(intent);
		finish();
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }
    
}
