package com.example.android.classroom;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class CourseMenuActivity extends AppCompatActivity {

    private TextView mCourseTitleEditText;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_course_menu);

        mCourseTitleEditText = (TextView) findViewById(R.id.course_title);
        mCourseTitleEditText.setText(getIntent().getStringExtra("courseCode"));

    }
}
