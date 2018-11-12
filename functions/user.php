<?php

// 登録処理
function user_register( $user_name, $nickname, $email, $password ) {

    $errors = user_validation( $user_name, $nickname, $email, $password );

    if ( count( $errors ) == 0 ) {
        user_insert( $user_name, $nickname, $email, $password );
    }

    foreach ( $errors as $error ) {
        print $error;
    }
}

// ユーザのバリデーション（若干抜けてる部分があるかもしれません）
function user_validation( $user_name, $nickname, $email, $password ) {

    $errors = array();

    if ( ! mb_strlen( trim( $user_name ) ) ) {
        $errors[] = "ユーザ名が空です";
    } else if ( mb_strlen( trim( $user_name ) ) > 15 ) {
        $errors[] = "ユーザ名は15文字以内で入力してください";
    } else if ( is_numeric( $user_name ) ) {
        $errors[] = "ユーザ名は文字列でなくてはいけません";
    }

    if ( ! mb_strlen( trim( $nickname ) ) ) {
        $errors[] = "nicknameが空です";
    } else if ( mb_strlen( trim( $nickname ) ) > 15 ) {
        $errors[] = "nicknameは15文字以内で入力してください";
    } else if ( ! isUniqueNickname( trim( $nickname ) ) ) {
        $errors[] = "nicknameが重複しています";
    } else if ( is_numeric( $nickname ) ) {
        $errors[] = "nicknameは文字列でなくてはいけません";
    }

    if ( ! mb_strlen( trim( $email ) ) ) {
        $errors[] = "emailが空です";
    } else if ( mb_strlen( trim( $email ) ) > 255 ) {
        $errors[] = "emailは255文字以内で入力してください";
    } 

    if ( ! mb_strlen( trim( $password ) ) ) {
        $errors[] = "passwordが空です";
    } else if ( ! preg_match( '/^[0-9a-z]{5,15}$/', trim( $password ) ) ) {
        $errors[] = "passwordは半角英数字5文字から15文字以内でお願いします";
    }   

    return $errors;
}

function isUniqueNickname( $nickname ) {
    $mysqli = get_db();

    $nickname = escape( $nickname );

    $query = "
        SELECT * FROM users
        WHERE nickname = '$nickname'
        ";

    $result = $mysqli->query( $query );

    if ( mysqli_num_rows( $result ) ==  0 ) {
        $mysqli->close();
        return true;
    }

    $result->close();

    return false;
}

function user_insert( $user_name, $nickname, $email, $password ) {
    $mysqli = get_db();

    // データをエスケープ
    $user_name = escape( $user_name );
    $nickname = escape( $nickname );
    $email = escape( $email );
    $password = escape( $password );
    $password = password_hash( $password, PASSWORD_DEFAULT ); // password hash化

    $query = "INSERT INTO users 
                ( user_name, nickname,  email, password 
            ) VALUES (
                '$user_name', '$nickname', '$email', '$password'
            )";

    if( $mysqli->query( $query ) ) {
        print 'ユーザの作成に成功しました';
    } else {
        printf("Errormessage: %s\n", $mysqli->error);
    }
}