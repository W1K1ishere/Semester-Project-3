<x-mail-layout title="Create Profile" text="Here is your link to create new profile:" :message="$message">
    <a href="{{ $createUrl }}" style="
                    display: inline-block;
                    background-color: #000;
                    color: #fff;
                    text-decoration: none;
                    padding: 12px 24px;
                    border-radius: 25px;
                    font-weight: bold;
                    margin-top: 20px;
                    ">Click Here
    </a>
</x-mail-layout>
