package com.example.android.classroom;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class AnswerQuestionActivity extends AppCompatActivity {

    private TextView mQuestionTextView;
    private EditText mAnswerEditText;
    private Button mSubmitButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_answer_question);

        String question = FakeData.getQuestion();
        String questionType = "shortAnswer";

        mQuestionTextView = (TextView) findViewById(R.id.question_textview);
        mQuestionTextView.setText(question);

        mAnswerEditText = (EditText) findViewById(R.id.answer_edittext);
        mSubmitButton = (Button) findViewById(R.id.submit_button);

        if (questionType == "shortAnswer") {
            mAnswerEditText.setVisibility(View.VISIBLE);
        } else if (questionType == "multipleChoice") {
            //TODO: display choices
        }

        mSubmitButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //TODO: submit to server
            }
        });
    }
}
