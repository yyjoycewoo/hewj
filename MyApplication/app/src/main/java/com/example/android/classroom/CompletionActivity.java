package com.example.android.classroom;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.DisplayMetrics;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;

public class CompletionActivity extends AppCompatActivity {
    private LinearLayout mCompletionLinearLayout;
    private Button mTypeOfGradingButton;

    String[] studentNames = FakeData.getStudentNames();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_completion);

        mCompletionLinearLayout = (LinearLayout) findViewById(R.id.completion_list);
        mTypeOfGradingButton = (Button) findViewById(R.id.type_of_grading_button);

        //default view is grading by completion
        generateCompletionGrading();

        mTypeOfGradingButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String currentButtonText = mTypeOfGradingButton.getText().toString();
                if (currentButtonText.equals(getString(R.string.title_completion_grade))) {
                    mTypeOfGradingButton.setText(R.string.title_numerical_grade);
                    toggle("completion");
                } else {
                    mTypeOfGradingButton.setText(R.string.title_completion_grade);
                    toggle("numerical");
                }
            }
        });
    }

    void toggle(String typeOfGrading) {
        int count = mCompletionLinearLayout.getChildCount();
        LinearLayout lineWrapper = null;
        for (int i=0; i<count; i++) {
            lineWrapper = (LinearLayout) mCompletionLinearLayout.getChildAt(i);
            lineWrapper.removeViewAt(1);

            if (typeOfGrading.equals("numerical")) {
                EditText grade = new EditText(this);
                lineWrapper.addView(grade);
            } else if (typeOfGrading.equals("completion")){
                CheckBox cb = new CheckBox(this);
                lineWrapper.addView(cb);
            }
        }
    }

    void generateCompletionGrading() {
        for (String name : studentNames) {
            //Create a wrapper for each student to show student name with checkbox
            LinearLayout lineWrapper = new LinearLayout(this);
            lineWrapper.setOrientation(LinearLayout.HORIZONTAL);
            LinearLayout.LayoutParams lineWrapperParams = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT);

            DisplayMetrics dm = new DisplayMetrics();
            this.getWindow().getWindowManager().getDefaultDisplay().getMetrics(dm);
            int width = dm.widthPixels;

            //Create TextView that displays the student name
            TextView student = new TextView(this);
            student.setText(name);
            student.setTextSize(getResources().getDimensionPixelSize(R.dimen.tv_textsize));
            student.setLayoutParams(new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT));
            student.getLayoutParams().width = width / 2;

            //Create a checkbox that will be displayed beside each name
            CheckBox cb = new CheckBox(this);


            lineWrapper.addView(student);
            lineWrapper.addView(cb);

            mCompletionLinearLayout.addView(lineWrapper);
        }
    }
}
