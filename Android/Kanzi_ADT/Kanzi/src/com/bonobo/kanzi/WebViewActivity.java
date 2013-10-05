package com.bonobo.kanzi;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.os.Bundle;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class WebViewActivity extends Activity {

	private WebView webView;
	
	@SuppressLint("SetJavaScriptEnabled") @Override
	protected void onCreate(Bundle savedInstanceState) {
		
		super.onCreate(savedInstanceState);
		setContentView(R.layout.webview);
		
		webView = (WebView) findViewById(R.id.webView);
		
		webView.setWebViewClient(new WebViewClient() {
			@Override
			public boolean shouldOverrideUrlLoading(WebView view, String url) {
				// TODO Auto-generated method stub
				return false;
			}
		});
		
		webView.getSettings().setJavaScriptEnabled(true);
		
		String webview_url = getString(R.string.webview_url);
		webView.loadUrl(webview_url);
		
	}
	
}
