<!DOCTYPE html>
<html lang="en">
@php
    $images = App\Models\ImageSetting::first();
@endphp

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('images/' . $images->favicon) }}">

    <link rel="stylesheet" href="{{ asset('front/css/normalize.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/./css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="{{ asset('web/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    @if (App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('front/css/style_ar.css') }}" />
        <style>
            body {
                background-color: #e4e4e6;
                font-family: "Cairo", sans-serif;
            }

            .cairo-custom-body {
                font-family: "Cairo", sans-serif;
                font-optical-sizing: auto;
                font-weight: 400;
                /* Example weight value, adjust as needed */
                font-style: normal;
                font-variation-settings: "slnt" 0;
            }

            /*signup Form*/
            .signup {
                position: relative;

                &::before {
                    content: "";
                    position: absolute;
                    width: 512px;
                    height: 512px;
                    border-radius: 50%;
                    top: 0;
                    right: 0;
                    transform: translate(9%, -58%) scale(3);
                    background-color: #295E4E;
                }

                .content {
                    display: flex;
                    justify-content: end;
                    height: 100vh;
                    align-items: center;
                    padding-left: 0;

                    .signup_form {
                        flex: 0 0 40%;
                        display: flex;
                        flex-direction: column;
                        align-items: center;

                        .heading {
                            max-width: 80%;

                            p {
                                color: #989a95;
                                font-weight: 500;
                            }
                        }


                    }

                    .image {
                        max-width: 35%;
                        position: absolute;
                        right: 18%;
                        bottom: 5%;

                        img {
                            width: 100%;
                        }
                    }
                }
            }

            @media (max-width: 767px) {
                body {
                    overflow: auto !important;
                }

                .signup {
                    position: relative;

                    &::before {
                        display: none;
                    }

                    .content {
                        display: flex;
                        justify-content: space-between;
                        height: 100vh;
                        align-items: center;
                        margin-top: 180px;
                        padding: 0 50px;

                        .signup_form {
                            flex: 0 0 100%;

                            .heading {
                                max-width: 100%;
                            }

                            form {
                                max-width: 100%;
                                width: 100%;

                                .name_inputs,
                                .email_phone_inputs,
                                .password_inputs {
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    flex-direction: column;

                                    .input {
                                        margin-bottom: 15px;
                                        display: flex;
                                        flex-direction: column;
                                        width: 100%;
                                        margin-right: 0 !important;
                                    }
                                }
                            }

                            .my-3,
                            .list-group,
                            .any_account {
                                width: 100%;
                            }

                            .any_account {
                                padding-bottom: 50px;
                            }
                        }

                        .image {
                            display: none;
                        }
                    }
                }
            }

            @media (max-width: 991px) {
                .signup {
                    position: relative;

                    &::before {
                        display: none;
                    }

                    .content {
                        display: flex;
                        justify-content: space-between;
                        height: 100vh;
                        align-items: center;
                        padding: 0 50px;

                        .signup_form {
                            flex: 0 0 100%;

                            .heading {
                                max-width: 100%;
                            }

                            form {
                                max-width: 100%;
                                width: 100%;

                                .name_inputs,
                                .email_phone_inputs,
                                .password_inputs {
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    flex-direction: column;

                                    .input {
                                        margin-bottom: 15px;
                                        display: flex;
                                        flex-direction: column;
                                        width: 100%;
                                        margin-right: 0 !important;
                                    }
                                }
                            }

                            .my-3,
                            .list-group,
                            .any_account {
                                width: 100%;
                            }
                        }

                        .image {
                            display: none;
                        }
                    }
                }
            }

            .phone_inputs {
                display: flex;
                justify-content: start;
                align-items: center;
                margin-bottom: 15px;
                gap: 10px;
                border: 1px solid #3333335e;
                width: 89%;
                border-radius: 10px;

                .input {
                    margin-right: 25px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex: 1;

                    label {
                        margin-bottom: 5px;
                        font-size: 16px;
                        font-weight: 600;
                        color: #989a95;
                        display: none;
                    }

                    input {
                        height: 40px;
                        border-radius: 10px;
                        outline: none;
                        padding: 0 15px;
                        padding-left: 0;
                        border: 0;
                        caret-color: #295E4E;
                        width: 100%;
                        background: transparent;
                    }

                    .code {
                        display: flex;
                        justify-content: start;
                        align-items: center;
                        color: #000;
                        gap: 7px;
                        padding: 0.8em;
                        border-radius: 10px;

                        img {
                            width: 25px;
                            object-fit: cover;
                        }
                    }
                }
            }

            @media (max-width:767px) {
                .phone_inputs {
                    width: 100%;
                }
            }

            @media (max-width:991px) {
                .phone_inputs {
                    width: 100%;
                }
            }



            form {
                max-width: 80%;
                margin-top: 25px;
                width: 100%;

                .name_inputs,
                .password_inputs {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 15px;

                    .input {
                        margin-right: 0px !important;
                        width: 100%;

                        input {
                            height: 40px;
                            border-radius: 10px;
                            outline: none;
                            border: 1px solid #3333335e;
                            padding: 0 15px;
                            caret-color: #295E4E;
                            background-color: transparent;

                            &:focus {
                                border: 1px solid #295E4E;
                            }
                        }
                    }

                }

                .check_input {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 3px;

                    label {
                        color: #989a95;
                        font-weight: 500;
                    }
                }

                a {
                    text-decoration: none;
                    color: #295E4E;
                    font-weight: 500;
                }

                input[type="submit"] {
                    display: block;
                    margin: auto;
                    padding: 8px 40px;
                    border-radius: 10px;
                    border: 0;
                    background: #295E4E;
                    color: #fff;
                    margin-top: 30px;
                }

                label {
                    margin-bottom: 5px;
                    font-size: 16px;
                    font-weight: 600;
                    color: #989a95;
                }

                .label_phone {
                    margin-left: -16px;
                }

                .margin {
                    margin-left: -17px;
                    width: 102%;
                }

                .inputs {
                    display: flex;
                    justify-content: start;
                    flex-direction: column;
                    margin-bottom: 20px;

                    input {
                        height: 40px;
                        border-radius: 10px;
                        outline: none;
                        border: 1px solid #3333335e;
                        padding: 0 15px;
                        caret-color: #295E4E;
                        background-color: transparent;

                        &:focus {
                            border: 1px solid #295E4E;
                        }
                    }
                }
            }

            .any_account {
                margin-top: 20px;
                color: #989a95;
                font-weight: 500;
                width: 80%;

                a {
                    color: #295E4E;
                    font-weight: 500;
                    text-decoration: none;
                }
            }
        </style>
        <style>
            .login {
                position: relative;

                &::before {
                    content: "";
                    position: absolute;
                    width: 512px;
                    height: 512px;
                    border-radius: 50%;
                    top: 0;
                    right: 0;
                    transform: translate(9%, -58%) scale(3);
                    background-color: #295E4E;
                }

                .content {
                    display: flex;
                    justify-content: end;
                    height: 100vh;
                    align-items: center;
                    padding-left: 0;

                    .login_form {
                        flex: 0 0 40%;
                        display: flex;
                        flex-direction: column;
                        align-items: center;

                        .heading {
                            max-width: 80%;

                            p {
                                color: #989a95;
                                font-weight: 500;
                            }
                        }

                        form {
                            max-width: 80%;
                            width: 100%;

                            .inputs {
                                display: flex;
                                justify-content: start;
                                flex-direction: column;
                                margin-bottom: 20px;

                                label {
                                    margin-bottom: 5px;
                                    font-size: 16px;
                                    font-weight: 600;
                                    color: #989a95;
                                }

                                input {
                                    height: 40px;
                                    border-radius: 10px;
                                    outline: none;
                                    border: 1px solid #eee;
                                    padding: 0 15px;
                                    caret-color: #295E4E;

                                    &:focus {
                                        border: 1px solid #295E4E;
                                    }
                                }

                                &:nth-of-type(2) {
                                    flex-direction: column;
                                    align-items: start;

                                    input {
                                        width: 100%;
                                    }
                                }

                                &:nth-of-type(3) {
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                    flex-direction: row;

                                    .check_input {
                                        display: flex;
                                        align-items: center;
                                        flex-direction: row-reverse;
                                        gap: 5px;

                                        label {
                                            margin: 0;
                                        }
                                    }
                                }
                            }

                            a {
                                text-decoration: none;
                                color: #295E4E;
                                font-weight: 500;
                            }

                            input[type="submit"] {
                                display: block;
                                margin: auto;
                                padding: 8px 40px;
                                border-radius: 10px;
                                border: 0;
                                background: #295E4E;
                                color: #fff;
                            }
                        }

                        .my-3 {
                            color: #989a95;
                            font-weight: 500;
                            width: 80%;
                        }

                        .list-group {
                            width: 80%;

                            ul {
                                list-style: none;
                                padding: 0;
                                margin: 0;
                                gap: 25px;
                                margin: 20px 0;
                            }
                        }

                        .any_account {
                            margin: 0;
                            color: #989a95;
                            font-weight: 500;
                            width: 80%;

                            a {
                                color: #295E4E;
                                font-weight: 500;
                                text-decoration: none;
                            }
                        }
                    }

                    .image {
                        max-width: 35%;
                        position: absolute;
                        right: 18%;
                        bottom: 5%;

                        img {
                            width: 100%;
                        }
                    }
                }
            }

            @media (max-width: 991px) {
                .login {
                    position: relative;

                    &::before {
                        display: none;
                    }

                    .content {
                        display: flex;
                        justify-content: space-between;
                        height: 100vh;
                        align-items: center;
                        padding: 0 50px;

                        .login_form {
                            flex: 0 0 100%;

                            .heading {
                                max-width: 100%;

                                p {
                                    color: #989a95;
                                    font-weight: 500;
                                }
                            }

                            form {
                                max-width: 100%;
                                width: 100%;

                                .inputs {
                                    display: flex;
                                    justify-content: start;
                                    flex-direction: column;
                                    margin-bottom: 20px;

                                    label {
                                        margin-bottom: 5px;
                                        font-size: 16px;
                                        font-weight: 600;
                                        color: #989a95;
                                    }

                                    input {
                                        height: 40px;
                                        border-radius: 10px;
                                        outline: none;
                                        border: 1px solid #eee;
                                        padding: 0 15px;
                                        caret-color: #295E4E;

                                        &:focus {
                                            border: 1px solid #295E4E;
                                        }
                                    }

                                    &:nth-child(3) {
                                        flex-direction: column;
                                        justify-content: space-between;

                                        .check_input {
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;

                                            label {
                                                margin: 0;
                                            }
                                        }
                                    }
                                }

                                a {
                                    text-decoration: none;
                                    color: #295E4E;
                                    font-weight: 500;
                                }

                                input[type="submit"] {
                                    display: block;
                                    margin: auto;
                                    padding: 8px 40px;
                                    border-radius: 10px;
                                    border: 0;
                                    background: #295E4E;
                                    color: #fff;
                                }
                            }

                            .my-3 {
                                color: #989a95;
                                font-weight: 500;
                                width: 100%;
                            }

                            .list-group {
                                width: 100%;

                                ul {
                                    list-style: none;
                                    padding: 0;
                                    margin: 0;
                                    gap: 25px;
                                    margin: 20px 0;
                                }
                            }

                            .any_account {
                                margin: 0;
                                color: #989a95;
                                font-weight: 500;
                                width: 100%;

                                a {
                                    color: #295E4E;
                                    font-weight: 500;
                                    text-decoration: none;
                                }
                            }
                        }

                        .image {
                            display: none;
                        }
                    }
                }
            }
        </style>
        <style>
            .Profile {
                & .content {
                    & .userdetails {
                        & .contentUserDetails {
                            & .Content {
                                & .orders {
                                    & .order {
                                        .date {
                                            padding: 15px;
                                            padding-top: 5px;
                                            margin-bottom: 15px;

                                            h3 {
                                                font-size: 1rem !important;
                                                opacity: 0.7;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            .Profile {
                & .content {
                    & .userdetails {
                        & .contentUserDetails {
                            & .Content {
                                & .orders {
                                    & .order {
                                        .title {
                                            margin-bottom: 5px;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            .personal_details {
                .phone_inputs {
                    position: relative;
                    margin-right: 25px;
                    margin-bottom: 0;
                    border: 1px solid #33333378;
                    height: 40px;
                    border-radius: 5px;

                    .input {
                        display: flex;

                        .code {
                            display: flex;
                            justify-content: start;
                            align-items: center;
                            color: #000;
                            gap: 7px;
                            padding: 0;
                            border-radius: 10px;

                            img {
                                width: 25px;
                                object-fit: cover;
                            }
                        }
                    }
                }
            }

            @media(max-width:767px) {
                .personal_details {
                    .phone_inputs {
                        position: relative;
                        margin-right: 25px;
                        margin-bottom: 0;
                        border: 1px solid #33333378;
                        height: 40px;
                        border-radius: 5px;

                        .input {
                            display: flex;

                            .code {
                                display: flex;
                                justify-content: start;
                                align-items: center;
                                color: #000;
                                gap: 7px;
                                padding: 0.8rem;
                                border-radius: 10px;

                                img {
                                    width: 25px;
                                    object-fit: cover;
                                }
                            }
                        }
                    }
                }
            }

            @media(max-width:991px) {
                .personal_details {
                    .phone_inputs {
                        position: relative;
                        margin-right: 25px;
                        margin-bottom: 0;
                        border: 1px solid #33333378;
                        height: 40px;
                        border-radius: 5px;

                        .input {
                            display: flex;

                            .code {
                                display: flex;
                                justify-content: start;
                                align-items: center;
                                color: #000;
                                gap: 7px;
                                padding: 0.8rem;
                                border-radius: 10px;

                                img {
                                    width: 25px;
                                    object-fit: cover;
                                }
                            }
                        }
                    }
                }
            }

            .Profile {
                & .content {
                    & .userdetails {
                        & .contentUserDetails {
                            & .Content {
                                & form {
                                    & .password {
                                        & .input {
                                            .image {
                                                position: absolute;
                                                max-width: 25px;
                                                right: 94%;
                                                top: 50%;
                                                cursor: pointer;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            @media(max-width:767px) {
                .Profile {
                    & .content {
                        & .userdetails {
                            & .contentUserDetails {
                                & .Content {
                                    & form {
                                        & .password {
                                            & .input {
                                                .image {
                                                    position: absolute;
                                                    max-width: 25px;
                                                    right: 87%;
                                                    top: 50%;
                                                    cursor: pointer;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            @media(max-width:991px) {
                .Profile {
                    & .content {
                        & .userdetails {
                            & .contentUserDetails {
                                & .Content {
                                    & form {
                                        & .password {
                                            & .input {
                                                .image {
                                                    position: absolute;
                                                    max-width: 25px;
                                                    right: 87%;
                                                    top: 50%;
                                                    cursor: pointer;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            .Profile {
                & .content {
                    & .userdetails {
                        & .contentUserDetails {
                            & .Content {
                                & form {
                                    input[type='submit'] {
                                        max-width: 120px;
                                        width: 100%;
                                        margin: auto;
                                        margin-top: 2rem !important;
                                        border-radius: 5px;
                                        color: #fff;
                                        background-color: #295E4E;
                                        cursor: pointer;
                                        height: 40px;
                                        display: block;
                                        border: 0;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            form {
                label {
                    margin-bottom: 5px;
                    font-size: 16px;
                    font-weight: 600;
                    color: #989a95;
                }
            }

            .Profile {
                & .content {
                    & .userdetails {
                        & .contentUserDetails {
                            & .Content {
                                & form {
                                    input[type='submit'] {
                                        max-width: 120px;
                                        width: 100%;
                                        margin-top: 1rem;
                                        border-radius: 5px;
                                        color: #fff;
                                        background-color: #295E4E;
                                        cursor: pointer;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            nav {
                .content {
                    .links {
                        ul {
                            a {
                                position: relative;

                                span {
                                    left: 10%;
                                }
                            }
                        }
                    }
                }
            }

            .modal-header {
                display: flex;

                h4 {
                    flex: 1;
                }
            }


            .modal-body {
                #signinForm {
                    max-width: 100%;
                    margin-top: 25px;
                    width: 100%;

                    label {
                        margin-bottom: 5px;
                        font-size: 16px;
                        font-weight: 600;
                        color: #989a95;
                    }

                    .phone_inputs {
                        display: flex;
                        justify-content: start;
                        align-items: center;
                        margin-bottom: 15px;
                        gap: 10px;
                        border: 1px solid #3333335e;
                        width: 93%;
                        border-radius: 10px;

                        .input {
                            margin-right: 25px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            flex: 1;

                            .code {
                                display: flex;
                                justify-content: start;
                                align-items: center;
                                color: #000;
                                gap: 7px;
                                padding: 0.8em 0 0.8em 0;
                                border-radius: 10px;
                                margin-right: -10px;

                                img {
                                    width: 25px;
                                    object-fit: cover;
                                }
                            }

                            input {
                                height: 40px;
                                border-radius: 10px;
                                outline: none;
                                padding: 0 15px;
                                padding-left: 0;
                                border: 0;
                                caret-color: #295E4E;
                                width: 100%;
                                background: transparent;
                            }
                        }
                    }

                    .inputs {
                        display: flex;
                        justify-content: start;
                        flex-direction: column;
                        margin-bottom: 20px;

                        input {
                            height: 40px;
                            border-radius: 10px;
                            outline: none;
                            padding: 0 15px;
                            padding-left: 0;
                            border: 0;
                            caret-color: #295E4E;
                            width: 100%;
                            background: transparent;
                            border: 1px solid #3333335e;

                            &:focus {
                                border: 1px solid #295E4E;
                            }
                        }
                    }

                    input[type="submit"] {
                        display: block;
                        margin: auto;
                        padding: 8px 40px;
                        border-radius: 10px;
                        border: 0;
                        background: #295E4E;
                        color: #fff;
                        margin-top: 30px;
                    }
                }

                #signupForm {
                    .container {
                        margin: auto 20px;
                    }

                    .check_input {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        gap: 3px;

                        label {
                            color: #989a95;
                            font-weight: 500;
                        }
                    }

                    input[type="submit"] {
                        display: block;
                        margin: auto;
                        padding: 8px 40px;
                        border-radius: 10px;
                        border: 0;
                        background: #295E4E;
                        color: #fff;
                        margin-top: 30px;
                    }

                    .name_inputs,
                    .password_inputs {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        margin-bottom: 15px;

                        .input {
                            margin-right: 0px;
                            flex: 1;

                            input {
                                height: 40px;
                                border-radius: 10px;
                                outline: none;
                                border: 1px solid #3333335e;
                                padding: 0 15px;
                                caret-color: #295E4E;
                                background-color: transparent;

                                &:focus {
                                    border: 1px solid #295E4E;
                                }
                            }
                        }
                    }

                    label {
                        margin-bottom: 5px;
                        font-size: 16px;
                        font-weight: 600;
                        color: #989a95;
                    }

                    .phone_inputs {
                        display: flex;
                        justify-content: start;
                        align-items: center;
                        margin-bottom: 15px;
                        gap: 10px;
                        border: 1px solid #3333335e;
                        width: 93%;
                        border-radius: 10px;

                        .input {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            flex: 1;

                            .code {
                                display: flex;
                                justify-content: start;
                                align-items: center;
                                color: #000;
                                gap: 7px;
                                padding: 0.8em;
                                border-radius: 10px;

                                img {
                                    width: 25px;
                                    object-fit: cover;
                                }
                            }

                            input {
                                height: 40px;
                                border-radius: 10px;
                                outline: none;
                                padding: 0 15px;
                                padding-left: 0;
                                border: 0;
                                caret-color: #295E4E;
                                width: 100%;
                                background: transparent;
                            }
                        }
                    }
                }

            }


            @media (max-width: 767px) {
                .program_details {
                    & .container {
                        .bg {
                            width: 358px !important;
                        }
                    }
                }
            }

            .order {
                & .content {
                    .step-4 {
                        display: none;
                        align-items: center;
                        width: 90%;
                        text-align: center;
                        justify-content: center;
                        margin: auto;
                        padding: 30px;
                    }
                }
            }

            @media (max-width: 767px) {
                .order {
                    & .content {
                        .next-stp {
                            margin-top: auto;
                            margin-bottom: 2rem;
                            margin-left: 0 !important;
                            border: none;
                            padding: 1rem 2rem;
                            border-radius: 7px;
                            background-color: var(--Marine-blue);
                            color: white;
                            cursor: pointer;
                        }

                        & .form {
                            .form-container {
                                width: 358px !important;
                            }
                        }

                        .form .form-container .form-sidebar {
                            background-color: #295E4E;
                            width: auto;
                            padding: 3rem 2rem;
                            display: flex;
                            flex-direction: row;
                            gap: 2rem;
                            border-radius: 0;
                            background-position: right;
                            border-radius: 7px !important;

                            .step .circle {
                                width: 40px !important;
                            }
                        }
                    }

                    .tiles_radio {
                        display: flex;
                        justify-content: start;
                        align-items: normal !important;
                        flex-direction: column;
                    }
                }
            }

            @media (max-width: 767px) {
                .order {
                    & .content {
                        & .step-1 {
                            .tiles {
                                display: flex;
                                justify-content: start;
                                align-items: center;
                                gap: 4px;
                                flex-wrap: nowrap !important;

                                .tile {
                                    label {
                                        .image {
                                            width: 140px;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                @media (max-width: 767px) {
                    .categories_cart {
                        .content {
                            flex-wrap: wrap;
                            gap: 20px;
                            margin-top: 40px;

                            .categories {
                                flex: 0 0 100%;
                                overflow: hidden;
                                background: transparent !important;

                                .menus {
                                    width: 630px;
                                    overflow: auto;

                                    .d-flex {
                                        column-gap: 20px;
                                        /* &::-webkit-scrollbar{
              width: 0px;
            } */
                                    }
                                }
                            }


                        }
                    }
                }

                .order {
                    & .content {
                        .step-4 {
                            display: none;
                            align-items: center;
                            width: 90%;
                            text-align: center;
                            justify-content: center;
                            margin: auto;
                            padding: 30px;
                        }
                    }
                }







                @media(max-width: 767px) {
                    .categories_cart {
                        & .content {
                            & .categories {
                                .menus {
                                    width: 630px;
                                    overflow: auto;

                                    &::-webkit-scrollbar {
                                        width: 0;
                                    }
                                }
                            }
                        }
                    }

                    .checkout {
                        .content {
                            gap: 20px;

                            .details {
                                flex: 0 0 100%;

                                .items {
                                    .item {
                                        flex: 0 0 100% !important;
                                    }
                                }
                            }

                            .form {
                                margin-top: 30px;
                            }
                        }
                    }

                    #signupForm {
                        .container {
                            margin: 0 !important;
                        }

                        .name_inputs,
                        .password_inputs {
                            flex-wrap: wrap;

                            .input {
                                margin-top: 10px;
                                flex: 1;
                                flex-direction: column;
                                display: flex;

                                input {
                                    height: 40px;
                                    border-radius: 10px;
                                    outline: none;
                                    border: 1px solid #3333335e;
                                    padding: 0 15px;
                                    caret-color: #295E4E;
                                    background-color: transparent;

                                    &:focus {
                                        border: 1px solid #295E4E;
                                    }
                                }
                            }
                        }

                        .phone_inputs {
                            width: 100% !important;
                        }
                    }


                }

                @media(max-width:991px) {
                    .checkout {
                        .content {
                            gap: 20px;

                            .details {
                                flex: 0 0 100%;

                                .items {
                                    .item {
                                        flex: 0 0 100% !important;
                                    }
                                }
                            }

                            .form {
                                margin-top: 30px;
                            }
                        }
                    }


                }






                .order {
                    form {
                        max-width: 100% !important;
                        width: 100%;
                    }
                }

                @media(max-width:767px) {
                    .order {

                        /*display:none;*/
                        form {
                            max-width: 100% !important;
                            width: 100%;
                        }
                    }
                }
        </style>
    @else
        <link rel="stylesheet" href="{{ asset('front/css/style2.css') }}" />
        <style>
            @media (max-width: 767px) {
                .program_details {
                    & .container {
                        .bg {
                            width: 358px !important;
                        }
                    }
                }
            }

            @media (max-width: 767px) {
                .order {
                    & .content {
                        .next-stp {
                            margin-top: auto;
                            margin-bottom: 2rem;
                            margin-left: 0;
                            border: none;
                            padding: 1rem 2rem;
                            border-radius: 7px;
                            background-color: var(--Marine-blue);
                            color: white;
                            cursor: pointer;
                        }

                        & .form {
                            .form-container {
                                width: 358px !important;
                            }
                        }

                        .form .form-container .form-sidebar {
                            background-color: #295E4E;
                            width: auto;
                            padding: 3rem 2rem;
                            display: flex;
                            flex-direction: row;
                            gap: 2rem;
                            border-radius: 0;
                            background-position: right;
                            border-radius: 7px !important;

                            .step .circle {
                                width: 40px !important;
                            }
                        }
                    }

                    .tiles_radio {
                        display: flex;
                        justify-content: start;
                        align-items: normal !important;
                        flex-direction: column;
                    }
                }
            }

            @media (max-width: 767px) {
                .order {
                    & .content {
                        & .step-1 {
                            .tiles {
                                display: flex;
                                justify-content: start;
                                align-items: center;
                                gap: 4px;
                                flex-wrap: nowrap !important;

                                .tile {
                                    label {
                                        .image {
                                            width: 140px;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }






                .modal-body {
                    #signupForm {
                        .container {
                            margin: 20px auto;
                        }
                    }
                }
            }
                @media(max-width: 767px) {
                    .categories_cart {
                        & .content {
                            & .categories {
                                .menus {
                                    width: 630px;
                                    overflow: auto;

                                    &::-webkit-scrollbar {
                                        width: 0;
                                    }
                                }
                            }
                        }
                    }
                }

                @media(max-width:991px) {
                    .checkout {
                        .content {
                            gap: 20px;

                            .details {
                                flex: 0 0 100%;

                                .items {
                                    .item {
                                        flex: 0 0 100% !important;
                                    }
                                }
                            }

                            .form {
                                margin-top: 30px;
                            }
                        }
                    }


                }

                .login {
                    position: relative;

                    &::before {
                        content: "";
                        position: absolute;
                        width: 512px;
                        height: 512px;
                        border-radius: 50%;
                        top: 0;
                        right: 0;
                        transform: translate(9%, -58%) scale(3);
                        background-color: #295E4E;
                    }

                    .content {
                        display: flex;
                        justify-content: start;
                        height: 100vh;
                        align-items: center;
                        padding-left: 50px;

                        .login_form {
                            flex: 0 0 40%;
                            display: flex;
                            flex-direction: column;
                            align-items: center;

                            .heading {
                                max-width: 80%;

                                p {
                                    color: #989a95;
                                    font-weight: 500;
                                }
                            }

                            form {
                                max-width: 80%;
                                width: 100%;

                                .inputs {
                                    display: flex;
                                    justify-content: start;
                                    flex-direction: column;
                                    margin-bottom: 20px;

                                    label {
                                        margin-bottom: 5px;
                                        font-size: 16px;
                                        font-weight: 600;
                                        color: #989a95;
                                    }

                                    input {
                                        height: 40px;
                                        border-radius: 10px;
                                        outline: none;
                                        border: 1px solid #eee;
                                        padding: 0 15px;
                                        caret-color: #295E4E;

                                        &:focus {
                                            border: 1px solid #295E4E;
                                        }
                                    }

                                    &:nth-of-type(2) {
                                        flex-direction: column;
                                        align-items: start;

                                        input {
                                            width: 100%;
                                        }
                                    }

                                    &:nth-of-type(3) {
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        flex-direction: row;

                                        .check_input {
                                            display: flex;
                                            align-items: center;
                                            flex-direction: row-reverse;
                                            gap: 5px;

                                            label {
                                                margin: 0;
                                            }
                                        }
                                    }
                                }

                                a {
                                    text-decoration: none;
                                    color: #295E4E;
                                    font-weight: 500;
                                }

                                input[type="submit"] {
                                    display: block;
                                    margin: auto;
                                    padding: 8px 40px;
                                    border-radius: 10px;
                                    border: 0;
                                    background: #295E4E;
                                    color: #fff;
                                }
                            }

                            .my-3 {
                                color: #989a95;
                                font-weight: 500;
                                width: 80%;
                            }

                            .list-group {
                                width: 80%;

                                ul {
                                    list-style: none;
                                    padding: 0;
                                    margin: 0;
                                    gap: 25px;
                                    margin: 20px 0;
                                }
                            }

                            .any_account {
                                margin: 0;
                                color: #989a95;
                                font-weight: 500;
                                width: 80%;

                                a {
                                    color: #295E4E;
                                    font-weight: 500;
                                    text-decoration: none;
                                }
                            }
                        }

                        .image {
                            max-width: 35%;
                            position: absolute;
                            right: 18%;
                            bottom: 5%;

                            img {
                                width: 100%;
                            }
                        }
                    }
                }

                .phone_inputs {
                    display: flex;
                    justify-content: start;
                    align-items: center;
                    margin-bottom: 15px;
                    gap: 10px;
                    border: 1px solid #3333335e;
                    width: 90%;
                    border-radius: 10px;

                    .input {
                        margin-right: 25px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex: 1;

                        label {
                            margin-bottom: 5px;
                            font-size: 16px;
                            font-weight: 600;
                            color: #989a95;
                            display: none;
                        }

                        input {
                            height: 40px;
                            border-radius: 10px;
                            outline: none;
                            padding: 0 15px;
                            padding-left: 0;
                            border: 0;
                            caret-color: #295E4E;
                            width: 100%;
                            background: transparent;
                        }

                        .code {
                            display: flex;
                            justify-content: start;
                            align-items: center;
                            color: #000;
                            gap: 7px;
                            padding: 0.8em;
                            border-radius: 10px;

                            img {
                                width: 25px;
                                object-fit: cover;
                            }
                        }
                    }
                }

                @media (max-width:767px) {
                    .phone_inputs {
                        width: 100%;
                    }
                }

                @media (max-width:991px) {
                    .phone_inputs {
                        width: 100%;
                    }
                }

                @media (max-width: 991px) {
                    .login {
                        position: relative;

                        &::before {
                            display: none;
                        }

                        .content {
                            display: flex;
                            justify-content: space-between;
                            height: 100vh;
                            align-items: center;
                            padding: 0 50px;

                            .login_form {
                                flex: 0 0 100%;

                                .heading {
                                    max-width: 100%;

                                    p {
                                        color: #989a95;
                                        font-weight: 500;
                                    }
                                }

                                form {
                                    max-width: 100%;
                                    width: 100%;

                                    .inputs {
                                        display: flex;
                                        justify-content: start;
                                        flex-direction: column;
                                        margin-bottom: 20px;

                                        label {
                                            margin-bottom: 5px;
                                            font-size: 16px;
                                            font-weight: 600;
                                            color: #989a95;
                                        }

                                        input {
                                            height: 40px;
                                            border-radius: 10px;
                                            outline: none;
                                            border: 1px solid #eee;
                                            padding: 0 15px;
                                            caret-color: #295E4E;

                                            &:focus {
                                                border: 1px solid #295E4E;
                                            }
                                        }

                                        &:nth-child(3) {
                                            flex-direction: row;
                                            align-items: center;
                                            justify-content: space-between;

                                            .check_input {
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;

                                                label {
                                                    margin: 0;
                                                }
                                            }
                                        }
                                    }

                                    a {
                                        text-decoration: none;
                                        color: #295E4E;
                                        font-weight: 500;
                                    }

                                    input[type="submit"] {
                                        display: block;
                                        margin: auto;
                                        padding: 8px 40px;
                                        border-radius: 10px;
                                        border: 0;
                                        background: #295E4E;
                                        color: #fff;
                                    }
                                }

                                .my-3 {
                                    color: #989a95;
                                    font-weight: 500;
                                    width: 100%;
                                }

                                .list-group {
                                    width: 100%;

                                    ul {
                                        list-style: none;
                                        padding: 0;
                                        margin: 0;
                                        gap: 25px;
                                        margin: 20px 0;
                                    }
                                }

                                .any_account {
                                    margin: 0;
                                    color: #989a95;
                                    font-weight: 500;
                                    width: 100%;

                                    a {
                                        color: #295E4E;
                                        font-weight: 500;
                                        text-decoration: none;
                                    }
                                }
                            }

                            .image {
                                display: none;
                            }
                        }
                    }
                }

                form {
                    max-width: 80%;
                    margin-top: 25px;
                    width: 100%;

                    .name_inputs,
                    .password_inputs {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 15px;

                        .input {
                            margin-right: 0px !important;
                            width: 100%;

                            input {
                                height: 40px;
                                border-radius: 10px;
                                outline: none;
                                border: 1px solid #3333335e;
                                padding: 0 15px;
                                caret-color: #295E4E;
                                background-color: transparent;

                                &:focus {
                                    border: 1px solid #295E4E;
                                }
                            }
                        }

                    }

                    .check_input {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        gap: 3px;

                        label {
                            color: #989a95;
                            font-weight: 500;
                        }
                    }

                    a {
                        text-decoration: none;
                        color: #295E4E;
                        font-weight: 500;
                    }

                    input[type="submit"] {
                        display: block;
                        margin: auto;
                        padding: 8px 40px;
                        border-radius: 10px;
                        border: 0;
                        background: #295E4E;
                        color: #fff;
                        margin-top: 30px;
                    }

                    label {
                        margin-bottom: 5px;
                        font-size: 16px;
                        font-weight: 600;
                        color: #989a95;
                    }

                    .label_phone {
                        margin-left: -16px;
                    }

                    .margin {
                        margin-left: -17px;
                        width: 102%;
                    }

                    .inputs {
                        display: flex;
                        justify-content: start;
                        flex-direction: column;
                        margin-bottom: 20px;

                        input {
                            height: 40px;
                            border-radius: 10px;
                            outline: none;
                            border: 1px solid #3333335e;
                            padding: 0 15px;
                            caret-color: #295E4E;
                            background-color: transparent;

                            &:focus {
                                border: 1px solid #295E4E;
                            }
                        }
                    }
                }

                .any_account {
                    margin-top: 20px;
                    color: #989a95;
                    font-weight: 500;
                    width: 80%;

                    a {
                        color: #295E4E;
                        font-weight: 500;
                        text-decoration: none;
                    }
                }

                .order {
                    form {
                        max-width: 100% !important;
                        width: 100%;
                    }
                }
        </style>
    @endif


    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css"
        integrity="sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link href="DynamicSelect.css" rel="stylesheet" type="text/css">

    @stack('css')


</head>

<body dir={{ App::getLocale() == 'ar' ? 'rtl' : '' }}>

    @include('layouts.ex_front.slider')
    @yield('content')



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('front/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
    @stack('js')

</body>

</html>
