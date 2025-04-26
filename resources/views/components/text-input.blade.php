@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} 
       class="border-gray-400 dark:text-gray-100 
              focus:border-[#3A3F6B] dark:focus:border-[#3A3F6B] 
              focus:ring-[#3A3F6B] dark:focus:ring-[#3A3F6B] 
              rounded-md shadow-sm w-full" 
       {{ $attributes }}>
