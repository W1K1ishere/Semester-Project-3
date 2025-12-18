<<x-mail-layout title="Create Profile" text="Here is your two factor authentification code:" :message="$message">
    <p style="
                    display: inline-block;
                    background-color: #000;
                    color: #fff;
                    text-decoration: none;
                    padding: 12px 24px;
                    border-radius: 25px;
                    font-weight: bold;
                    margin-top: 20px;
                    ">Code : {{ $code }}
    </p>
</x-mail-layout>
