package com.example.android.classroom;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONException;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

/**
 * A login screen that offers login via email/password.
 */
public class LoginActivity extends AppCompatActivity {

    // UI references.
    private EditText mUTORidView;
    private EditText mPasswordView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        // Set up the login form.
        mUTORidView = (EditText) findViewById(R.id.email);
        mPasswordView = (EditText) findViewById(R.id.password);
        Button mEmailSignInButton = (Button) findViewById(R.id.email_sign_in_button);
        mEmailSignInButton.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                attemptLogin();
            }
        });

        Button mStudentLogin = (Button) findViewById(R.id.student_login_button);
        mStudentLogin.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                goToCourseList("student");
            }
        });


    }

    private void goToCourseList(String status) {
        Intent intent = new Intent(this, CourseListActivity.class);
        intent.putExtra("status", status);
        startActivity(intent);
    }


    /**
     * Attempts to sign in or register the account specified by the login form.
     * If there are form errors (invalid email, missing fields, etc.), the
     * errors are presented and no actual login attempt is made.
     */
    private void attemptLogin() {
        Log.d("LoginActivity", "attempting to log in");

        // Reset errors.
        mUTORidView.setError(null);
        mPasswordView.setError(null);

        // Store values at the time of the login attempt.
        String email = mUTORidView.getText().toString();
        String password = mPasswordView.getText().toString();

        boolean cancel = false;
        View focusView = null;

        // Check for a valid password, if the user entered one.
        if (!isPasswordValid(password)) {
            mPasswordView.setError(getString(R.string.error_invalid_password));
            focusView = mPasswordView;
            cancel = true;
        }

        // Check for a valid email address.
        if (TextUtils.isEmpty(email)) {
            mUTORidView.setError(getString(R.string.error_field_required));
            focusView = mUTORidView;
            cancel = true;
        }

        RestClientUsage rcu = new RestClientUsage();
        try {
            rcu.logIn();
        } catch (JSONException jsone) {
            Log.e("LoginActivity", "JSONException");
        }
    }

    private boolean isPasswordValid(String password) {
        return (password.length() >= 8);
    }

    class RestClientUsage {
        public void logIn() throws JSONException {
            RequestParams params = new RequestParams();
            params.add("username", mUTORidView.getText().toString());
            params.add("password", mPasswordView.getText().toString());

            RestClient.get("login", params, new JsonHttpResponseHandler() {
                @Override
                public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                    // If the response is JSONObject instead of expected JSONArray
                    Log.d("LoginActivity", response.toString());
                    JSONSingleton.getInstance().mJSONObject = response;
                    goToCourseList("instructor");
                }

                @Override
                public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse) {
                    Log.e("LoginActivity", errorResponse.toString());
                    //Snackbar.make(LoginActivity.class, "Welcome to AndroidHive", Snackbar.LENGTH_LONG).show();
                }
            });
        }
    }

}

