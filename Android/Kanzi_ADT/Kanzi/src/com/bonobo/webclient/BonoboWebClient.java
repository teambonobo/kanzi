package com.bonobo.webclient;

import android.webkit.WebView;
import android.webkit.WebViewClient;

public class BonoboWebClient extends WebViewClient {
	
	@Override
	public boolean shouldOverrideUrlLoading(WebView view, String url) {
		
		return false;
	}

}
