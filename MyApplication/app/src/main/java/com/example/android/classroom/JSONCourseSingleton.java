package com.example.android.classroom;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by JoyceWoo on 2017-01-08.
 */

public class JSONCourseSingleton {
    private static JSONCourseSingleton mInstance = null;

    public JSONArray mJSONArray;

    protected JSONCourseSingleton() {
    }

    public static synchronized JSONCourseSingleton getInstance() {
        if (null == mInstance)
            mInstance = new JSONCourseSingleton();

        return mInstance;
    }

    public static JSONObject getCourse(int i) {
        try {
            return JSONCourseSingleton.getInstance().mJSONArray.getJSONObject(i);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

    public static int getNumCourses() {
        return JSONCourseSingleton.getInstance().mJSONArray.length();
    }

    public static String getIthCourseCode(int i) {
        try {
            JSONCourseSingleton.getInstance().mJSONArray.getJSONObject(i).get("coursecode").toString();
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

    public static String getIthMeetingSection(int i) {
        try {
            JSONCourseSingleton.getInstance().mJSONArray.getJSONObject(i).get("meetingsection").toString();
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

    public static String getIthCourseId(int i) {
        try {
            JSONCourseSingleton.getInstance().mJSONArray.getJSONObject(i).get("id").toString();
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }


}