package com.example.android.classroom;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class QuestionActivity extends AppCompatActivity {

    private LinearLayout mQuestionList;
    private Button mNewQuestionButton;
    private List<String> mQuestions;
    private Button mQuestion1Button;
    private Button mQuestion2Button;
    private Button mQuestion3Button;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_question);

        mQuestionList = (LinearLayout) findViewById(R.id.question_list);
        mQuestion1Button = (Button) findViewById(R.id.question1);
        mQuestion2Button = (Button) findViewById(R.id.question2);
        mQuestion3Button = (Button) findViewById(R.id.question3);

        mNewQuestionButton = (Button) findViewById(R.id.new_question);
        mNewQuestionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                goToNewQuestion();
            }
        });


        mQuestion1Button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mQuestion1Button.setBackgroundColor(getResources().getColor(R.color.emeraldGreen));
            }
        });

        mQuestion2Button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mQuestion2Button.setBackgroundColor(getResources().getColor(R.color.emeraldGreen));
            }
        });

        mQuestion3Button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mQuestion3Button.setBackgroundColor(getResources().getColor(R.color.emeraldGreen));
            }
        });

        String questionText = "%s. %s";


        //mQuestionList.getChildAt(1).setBackgroundColor(0xFF00FF00);
    }

    private void goToNewQuestion() {
        Intent intent = new Intent(this, NewQuestionActivity.class);
        startActivity(intent);
    }
}
