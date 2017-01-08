package com.example.android.classroom;

import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;

import static android.view.View.VISIBLE;

public class AnswerQuestionActivity extends AppCompatActivity {

    private TextView mQuestionTextView;
    private EditText mAnswerEditText;
    private Button mSubmitButton;
    private Button mAnswer1Button;
    private Button mAnswer2Button;
    private Button mAnswer3Button;
    private LinearLayout mAnswerList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_answer_question);

        String question = FakeData.getMCQuestion();
        String questionType = "multipleChoice";

        mQuestionTextView = (TextView) findViewById(R.id.question_textview);
        mQuestionTextView.setText(question);
        mAnswerList = (LinearLayout) findViewById(R.id.answer_list);

        mAnswerEditText = (EditText) findViewById(R.id.answer_edittext);
        mSubmitButton = (Button) findViewById(R.id.submit_button);
        mAnswer1Button = (Button) findViewById(R.id.answer1);
        mAnswer2Button = (Button) findViewById(R.id.answer2);
        mAnswer3Button = (Button) findViewById(R.id.answer3);

        if (questionType == "shortAnswer") {
            mAnswerEditText.setVisibility(View.VISIBLE);
        } else if (questionType == "multipleChoice") {
            mAnswerList.setVisibility(VISIBLE);
            mSubmitButton.setVisibility(View.INVISIBLE);
        }

        mSubmitButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //TODO: submit to server
            }
        });

        mAnswer1Button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mAnswer1Button.setBackgroundColor(getResources().getColor(R.color.emeraldGreen));
            }
        });

        mAnswer2Button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mAnswer2Button.setBackgroundColor(getResources().getColor(R.color.emeraldGreen));
            }
        });

        mAnswer3Button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mAnswer3Button.setBackgroundColor(getResources().getColor(R.color.emeraldGreen));
            }
        });
    }

}
