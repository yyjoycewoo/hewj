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

        String position = JSONSingleton.getPositionStr();
        JSONArray courses = null;

        if (position.equals("Professor") || (position.equals("Teaching Assistant"))) {
            try {
                courses = JSONSingleton.getUser().getJSONArray("teaches");
            } catch (JSONException e) {
                e.printStackTrace();
            }
        } else {
            try {
                courses = JSONSingleton.getUser().getJSONArray("takes");
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }

        for (int i = 0; i < courses.length(); i++) {
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
