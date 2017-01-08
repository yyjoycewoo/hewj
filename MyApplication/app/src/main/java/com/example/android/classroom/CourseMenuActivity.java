package com.example.android.classroom;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

import org.json.JSONException;
public class CourseMenuActivity extends AppCompatActivity {

    private TextView mCourseTitleTextView;

    private Button mAttendanceButton;
    private Button mAnsQuestionButton;
    private Button mWtfButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_course_menu);

        mCourseTitleTextView = (TextView) findViewById(R.id.course_title);
        final String courseCode = getIntent().getStringExtra("courseCode");
        mCourseTitleTextView.setText(courseCode);

        mAttendanceButton = (Button) findViewById(R.id.im_here_button);
        mAnsQuestionButton = (Button) findViewById(R.id.ans_question_button);
        mWtfButton = (Button) findViewById(R.id.wtf_button);

        mAttendanceButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                RequestParams params = new RequestParams();
                params.add("course_id", "10");

                String student_id = null;
                try {
                    student_id = JSONUserSingleton.getInstance().mJSONObject.getJSONObject("user").get("user_id").toString();
                } catch (Exception e) {
                    Log.d("CourseMenuActivity", e.toString());
                }
                params.add("student_id", student_id);

                RestClient.get("setAttendence", null, new JsonHttpResponseHandler() {
                    @Override
                    public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                        // If the response is JSONObject instead of expected JSONArray
                        Log.d("CourseMenyActivity", response.toString());
                    }

                    @Override
                    public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse) {
                        Log.e("CourseMenyActivity", errorResponse.toString());
                    }
                });

                mAttendanceButton.setText("Attendance Taken");
                params = new RequestParams();
                params.add("course_id", courseCode);
                try {
                    params.add("student_id", JSONUserSingleton.getUser().get("user_id").toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                RestClient.get("setAttendence", params, new JsonHttpResponseHandler() {
                    @Override
                    public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                        // If the response is JSONObject instead of expected JSONArray
                        Log.d("CourseMenuActivity", response.toString());
                    }

                    @Override
                    public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse) {
                        Log.e("CourseMenuActivity", errorResponse.toString());
                    }
                });
            }
        });

        mAnsQuestionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                goToQuestion();
            }
        });

        mWtfButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mWtfButton.setText("WTF submitted");
            }
        });
    }

    private void getCourseId() {
        RequestParams params = new RequestParams();
        params.add("session", null);
        params.add("course_code", null);
        params.add("session_type", null);
        params.add("session_number", null);
        RestClient.get("setAttendence", params, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                // If the response is JSONObject instead of expected JSONArray
                Log.d("CourseMenuActivity", response.toString());
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse) {
                Log.e("CourseMenuActivity", errorResponse.toString());
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.log_out, menu);

        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.log_out_item:
                Toast.makeText(this, "Log out selected.", Toast.LENGTH_SHORT).show();
                RestClient.get("logout", null, new JsonHttpResponseHandler() {
                            @Override
                            public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                                // If the response is JSONObject instead of expected JSONArray
                                Log.d("CourseListActivity", response.toString());
                                goBackToLogin();
                            }

                            @Override
                            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse) {
                                Log.e("LoginActivity", errorResponse.toString());
                            }
                        }
                );
                break;
        }

        return true;
    }

    private void goBackToLogin() {
        startActivity(new Intent(this, LoginActivity.class));
    }

    private void goToQuestion() {
        Intent intent = new Intent(this, AnswerQuestionActivity.class);
        startActivity(intent);
    }
}
