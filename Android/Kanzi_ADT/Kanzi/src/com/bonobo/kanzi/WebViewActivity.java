package com.bonobo.kanzi;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.os.Bundle;
import android.webkit.WebSettings;
import android.webkit.WebView;

import com.bonobo.web.client.BonoboWebClient;

@SuppressLint("SetJavaScriptEnabled")
public class WebViewActivity extends Activity {

	private WebView webView;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		
		super.onCreate(savedInstanceState);
		setContentView(R.layout.webview);
		
		webView = getConfiguredWebView();
		
		String webview_url = getString(R.string.webview_url);
		webView.loadUrl(webview_url);
		
	}
	
	@Override
	public void onBackPressed() {
		
		finish();
	}
	
	@SuppressWarnings("deprecation")
	private WebView getConfiguredWebView() {
		
		WebView webView = (WebView) findViewById(R.id.webView);
		
		webView.setWebViewClient(new BonoboWebClient());
		webView.getSettings().setJavaScriptEnabled(true);
		webView.getSettings().setDomStorageEnabled(true);
		// Set cache size to 8 mb by default. should be more than enough
		webView.getSettings().setAppCacheMaxSize(1024*1024*8);
		String appCachePath = getApplicationContext().getCacheDir().getAbsolutePath();
		webView.getSettings().setAppCachePath(appCachePath);
		webView.getSettings().setAllowFileAccess(true);
		webView.getSettings().setAppCacheEnabled(true);
		webView.getSettings().setCacheMode(WebSettings.LOAD_DEFAULT);
		
		return webView;
	}
	
}
