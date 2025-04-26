<style>
    .custom-button {
        padding: 10px 20px;
        background-color: #3A3F6B;
        color: white;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        transition: background-color 0.6s ease;
        text-decoration: none;
        border: 1px solid #3A3F6B;
    }
    
    .custom-button:hover {
        background-color: white; /* Change the background color on hover */
            color: #3A3F6B;
    }
</style>

<button class="custom-button">
    {{ $slot }}
</button>
