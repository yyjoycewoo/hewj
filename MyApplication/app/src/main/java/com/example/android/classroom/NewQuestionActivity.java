package com.example.android.classroom;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;

import static android.view.View.INVISIBLE;
import static android.view.View.VISIBLE;

public class NewQuestionActivity extends AppCompatActivity {

    private EditText mNewQuestionEditText;
    private Button mQuestionTypeButton;
    private LinearLayout mAnswerList;
    private Button mGoButton;

    private enum AnswerType {
        MULTIPLE_CHOICE, SHORT_ANSWER
    }

    private AnswerType mCurrAnswerType = AnswerType.SHORT_ANSWER;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_new_question);

        mNewQuestionEditText = (EditText) findViewById(R.id.new_question_edit_text);
        mAnswerList = (LinearLayout) findViewById(R.id.answer_list);

        mQuestionTypeButton = (Button) findViewById(R.id.answer_type_button);
        mQuestionTypeButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                toggleAnswerType();
            }
        });
        setLayoutVisibility();
        setAnswerType("SHORT ANSWER");

        mGoButton = (Button) findViewById(R.id.go_button);
    }

    private void toggleAnswerType() {
        if (mCurrAnswerType.equals(AnswerType.MULTIPLE_CHOICE)) {
            mCurrAnswerType = AnswerType.SHORT_ANSWER;
            setAnswerType("SHORT ANSWER");
        } else {
            mCurrAnswerType = AnswerType.MULTIPLE_CHOICE;
            setAnswerType("MULTIPLE CHOICE");
        }

        setLayoutVisibility();
    }

    private void setAnswerType(String text) {
        mQuestionTypeButton.setText(text);
    }

    private void setLayoutVisibility() {
        if (mCurrAnswerType.equals(AnswerType.MULTIPLE_CHOICE)) {
            mAnswerList.setVisibility(VISIBLE);
        } else {
            mAnswerList.setVisibility(INVISIBLE);
        }
    }
}
