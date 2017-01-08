package com.example.android.classroom;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

public class CourseListActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_student_course_list);

        LinearLayout courseListLinearLayout = (LinearLayout)
                findViewById(R.id.activity_student_course_list);

        String position = JSONSingleton.getPositionStr();
        JSONArray courses = null;

        RestClient.get("getCoursesCurrentLoggedInStudentIsIn", null, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONArray response) {
                // If the response is JSONObject instead of expected JSONArray
                Log.d("CourseListActivity", response.toString());
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse) {
                Log.e("CourseListActivity", errorResponse.toString());
            }
        });
/*
        if (position.equals("Professor") || (position.equals("Teaching Assistant"))) {
            try {
                courses = JSONSingleton.getUser().getJSONArray("teaches");
            } catch (JSONException e) {
                e.printStackTrace();
            }
        } else {
            // user must be a student
            try {
                courses = JSONSingleton.getUser().getJSONArray("takes");
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
*/
/*        for (int i = 0; i < courses.length(); i++) {
            Log.d("CourseListActivity", courses.toString());

            String courseCode = "";
            try {
                courseCode = courses.getJSONObject(i).get("coursecode").toString();
                courseCode += " - ";
                courseCode += courses.getJSONObject(i).get("meetingsection").toString();
                Log.d("CourseListActivity", courseCode);
            } catch (JSONException e) {
                e.printStackTrace();
            }
            Button course = new Button(this);
            course.setText(courseCode);

            final String finalCourseCode = courseCode;
            course.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    goTo(finalCourseCode);
                }
            });
            course.setTextSize(getResources().getDimensionPixelSize(R.dimen.tv_textsize));

            courseListLinearLayout.addView(course);
        }
*/
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

    private void goTo(String courseCode) {
        Intent intent = null;
        if (getIntent().getStringExtra("status").equals("instructor")) {
            intent = new Intent(this, InstructorMenuActivity.class);
            intent.putExtra("courseCode", courseCode);
        } else if (getIntent().getStringExtra("status").equals("student")) {
            intent = new Intent(this, CourseMenuActivity.class);
            intent.putExtra("courseCode", courseCode);
        }
        startActivity(intent);
    }

    private void goBackToLogin() {
        startActivity(new Intent(this, LoginActivity.class));
    }
}
