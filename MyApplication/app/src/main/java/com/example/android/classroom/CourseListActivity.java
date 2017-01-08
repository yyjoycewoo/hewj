package com.example.android.classroom;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;

import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

public class CourseListActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_student_course_list);

        LinearLayout courseListLinearLayout = (LinearLayout)
                findViewById(R.id.activity_student_course_list);
        //String[] courses = FakeData.getCourses();
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
                                Log.d("LoginActivity", response.toString());
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
}
