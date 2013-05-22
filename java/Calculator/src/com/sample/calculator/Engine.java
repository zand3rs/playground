/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sample.calculator;

/**
 *
 * @author king
 */
public class Engine {

    private static double lastAnswer = 0;
    private static double lastNumber = 0;
    private static String lastOperator = "";

    public static void reset() {
        lastAnswer = 0;
        lastNumber = 0;
        lastOperator = "";
    }

    public static double getAnswer() {
        return lastAnswer;
    }

    public static void processExpression(String exp) {
        String[] params = exp.split(" ");

        for (int i = 0; i < params.length; ++i) {
            String token = params[i].trim();
            if (token.matches("[-+*/]")) {
                processOperator(token);
            } else {
                processNumber(token);
            }
        }
    }

    public static void processNumber(String num) {
        int curNumber = Integer.parseInt(num);

        if (lastOperator.equals("+")) {
            lastAnswer = lastNumber + curNumber;
        } else if (lastOperator.equals("-")) {
            lastAnswer = lastNumber - curNumber;
        } else if (lastOperator.equals("*")) {
            lastAnswer = lastNumber * curNumber;
        } else if (lastOperator.equals("/")) {
            lastAnswer = lastNumber / curNumber;
        } else {
            lastAnswer = curNumber;
        }
        lastNumber = lastAnswer;
    }

    public static void processOperator(String op) {
        lastOperator = op;
    }
    
}
