package com.example.android.classroom;

import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.DisplayMetrics;
import android.view.Gravity;
import android.view.View;
import android.widget.CheckBox;
import android.widget.LinearLayout;
import android.widget.TextView;

public class CompletionActivity extends AppCompatActivity {
    private LinearLayout completionLinearLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_completion);

        completionLinearLayout = (LinearLayout) findViewById(R.id.completion_list);

        String[] studentNames = FakeStudentNames.getStudentNames();

        for (String name : studentNames) {
            LinearLayout lineWrapper = new LinearLayout(this);
            lineWrapper.setOrientation(LinearLayout.HORIZONTAL);
            LinearLayout.LayoutParams lineWrapperParams = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT);
            lineWrapper.setGravity(Gravity.CENTER);

            DisplayMetrics dm = new DisplayMetrics();
            this.getWindow().getWindowManager().getDefaultDisplay().getMetrics(dm);
            int width = dm.widthPixels;

            TextView student = new TextView(this);
            student.setText(name);

            student.setTextSize(getResources().getDimensionPixelSize(R.dimen.tv_textsize));
            student.setLayoutParams(new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT));

            CheckBox cb = new CheckBox(this);

            lineWrapper.addView(student);
            student.getLayoutParams().width = width/2;
            lineWrapper.addView(cb);

            completionLinearLayout.addView(lineWrapper);
        }
    }
}
