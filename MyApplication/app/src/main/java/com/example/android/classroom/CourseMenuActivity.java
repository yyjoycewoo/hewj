package com.example.android.classroom;

import android.content.Intent;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

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
        mCourseTitleTextView.setText(getIntent().getStringExtra("courseCode"));

        mAttendanceButton = (Button) findViewById(R.id.im_here_button);
        mAnsQuestionButton = (Button) findViewById(R.id.ans_question_button);
        mWtfButton = (Button) findViewById(R.id.wtf_button);

        mAttendanceButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mAttendanceButton.setText("Attendance Taken");
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

    private void goToQuestion() {
        Intent intent = new Intent(this, AnswerQuestionActivity.class);
        startActivity(intent);
    }
}
