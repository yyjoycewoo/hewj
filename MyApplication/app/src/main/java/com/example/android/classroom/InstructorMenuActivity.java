package com.example.android.classroom;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import static android.R.attr.type;

public class InstructorMenuActivity extends AppCompatActivity {

    private Button mAttendanceButton;
    private Button mQuestionButton;
    private Button mCompletionButton;
    private TextView mMenuTextView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);

        mMenuTextView = (TextView) findViewById(R.id.menu_textview);
        mMenuTextView.append(": " + getIntent().getStringExtra("courseCode"));

        mAttendanceButton = (Button) findViewById(R.id.attendance_button);
        mAttendanceButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                goTo("attendance");
            }
        });

        mQuestionButton = (Button) findViewById(R.id.question_button);
        mQuestionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                goTo("question");
            }
        });

        mCompletionButton = (Button) findViewById(R.id.completion_button);
        mCompletionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                goTo("completion");
            }
        });
    }

    public void goTo(String activity) {
        Intent intent = null;

        if (activity.equalsIgnoreCase("attendance")) {
            intent = new Intent(this, AttendanceActivity.class);
        } else if (activity.equalsIgnoreCase("question")) {
            intent = new Intent(this, QuestionActivity.class);
        } else if (activity.equalsIgnoreCase("completion")) {
            intent = new Intent(this, CompletionActivity.class);
        }

        startActivity(intent);
    }
}
