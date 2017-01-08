package com.example.android.classroom;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class QuestionActivity extends AppCompatActivity {

    private LinearLayout mQuestionList;
    private List<String> mQuestions = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_question);

        /*FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });*/

        mQuestionList = (LinearLayout) findViewById(R.id.question_list);
        mQuestions = new ArrayList<>();

        populateQuestions(mQuestions);

        String questionText = "%s. %s";

        int i;
        for (i = 0; i < mQuestions.size(); i++) {
            TextView student = new TextView(this);
            student.setText(String.format(questionText, i + 1, mQuestions.get(i)));
            student.setTextSize(getResources().getDimensionPixelSize(R.dimen.tv_textsize));
            student.setLayoutParams(new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT));

            mQuestionList.addView(student);
        }

        //mQuestionList.getChildAt(1).setBackgroundColor(0xFF00FF00);
    }

    private void populateQuestions(List array) {
        array.add("hi");
        array.add("world");
        array.add("hi");
        array.add("world");
        array.add("hi");
        array.add("world");
        array.add("hi");
        array.add("world");
        array.add("hi");
        array.add("world");
    }
}
