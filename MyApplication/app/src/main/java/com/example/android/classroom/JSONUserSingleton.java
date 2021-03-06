package com.example.android.classroom;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by williamkim on 2017-01-08.
 */

public class JSONUserSingleton {
    private static JSONUserSingleton mInstance = null;

    public JSONObject mJSONObject;

    protected JSONUserSingleton() {
    }

    public static synchronized JSONUserSingleton getInstance() {
        if (null == mInstance)
            mInstance = new JSONUserSingleton();

        return mInstance;
    }

    public static String getPositionStr() {
        try {
            return mInstance.mJSONObject.getJSONObject("user").get("positionStr").toString();
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

    public static JSONObject getUser() {
        try {
            return mInstance.mJSONObject.getJSONObject("user");
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

}