package com.example.android.classroom;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.LinearLayout;
import android.widget.TextView;

public class AttendanceActivity extends AppCompatActivity {

    private TextView mStudentNamesTextView;
    private LinearLayout attendanceLinearLayout;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_attendance);
        attendanceLinearLayout = (LinearLayout) findViewById(R.id.attendance_list);

        String[] studentNames = FakeStudentNames.getStudentNames();

        for (String name : studentNames) {
            TextView student = new TextView(this);
            student.setText(name);
            student.setTextSize(getResources().getDimensionPixelSize(R.dimen.tv_textsize));
            student.setLayoutParams(new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT));

            ((LinearLayout) attendanceLinearLayout).addView(student);
        }

        attendanceLinearLayout.getChildAt(2).setBackgroundColor(0xFF00FF00);

    }
}

