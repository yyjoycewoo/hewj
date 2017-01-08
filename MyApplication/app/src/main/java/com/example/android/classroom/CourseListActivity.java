package com.example.android.classroom;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class CourseListActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_student_course_list);

        LinearLayout courseListLinearLayout = (LinearLayout)
                findViewById(R.id.activity_student_course_list);
        //String[] courses = FakeData.getCourses();
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
