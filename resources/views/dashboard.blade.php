<x-app-layout>
    @section('title', 'Dashboard')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    
    <!-- Automatically Display Notifications and Appointment Details in One Card -->
    <div class="py-1 max-w-7xl mx-auto sm:px-6 lg:px-8">
      

  
    
    <div class="invoice-container border border-gray-300 rounded-lg p-6 dark:bg-gray bg-gray shadow-md mt-6 relative">
<br>
<br>
        <!-- Fixed Centered Image -->
        <img src="{{ asset('img/ssdc_logo2.png') }}" alt="Logo" 
            class="absolute top-25 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-20 h-20 border-2 border-gray-500 rounded-full">
    <br>
        <!-- Invoice Header -->
        <div class="text-center font-semibold text-3xl text-gray-800 mt-10">
            <span class="text-blue-600">Your</span> Appointment
        </div>

        <div class="border border-gray-300 rounded-lg p-6 bg-gray  dark:bg-white shadow-md mt-6">
            
            <!-- Invoice Title -->
            <div class="flex justify-between items-center border-b pb-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-700">Billing Invoice</h1>
                    <br>
                    <p class="text-sm text-gray-500">Issued on: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-lg font-semibold text-gray-700">
                        INVOICE #{{ $appointments ? $appointments->id : 'N/A' }}
                    </h2>
                    
                    <br>
                    <p class="text-sm text-gray-500">
                        Status: 
                        <span class="px-2 py-1 text-[14px] font-semibold rounded-md 
                        @if($appointments && $appointments->status == 'pending') 
                            bg-yellow-100 text-yellow-600 
                        @elseif($appointments && $appointments->status == 'accepted') 
                            bg-green-100 text-green-600 
                        @elseif($appointments && $appointments->status == 'declined') 
                            bg-red-100 text-red-600 
                        @else 
                            bg-gray-100 text-gray-600 
                        @endif">
                        {{ $appointments ? ucfirst($appointments->status) : 'N/A' }}
                    </span>
                    
                    </p>
                </div>
            </div>
            
            <!-- Billing Details -->
            <div class="mt-4 flex justify-between">
                <div>
                    <p class="font-semibold text-gray-600">Billed To:</p>
                    <p class="text-sm text-gray-500">{{ auth()->user()->name ?? 'Unknown' }}</p>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-600">Doctor:</p>
                    <span id="doctor-name" class="text-sm text-gray-500"></span>
                </div>
            </div>
            <script>
                fetch('/admin/details')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("doctor-name").innerText = data.name || "Dr. Unknown";
                    })
                    .catch(error => console.error("Error fetching admin:", error));
            </script>
    
           <!-- Responsive Table Container -->
        <div class="overflow-x-auto mt-6">
            <table class="w-full border-collapse border border-gray-200 min-w-[600px]">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-600">Procedure</th>
                        <th class="border border-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-600">Date</th>
                        <th class="border border-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-600">Time</th>
                        <th class="border border-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-600">Duration</th>
                        <th class="border border-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-600">Price</th>
                        <th class="border border-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border border-gray-200">
                        <td class="px-4 py-2 text-center text-sm text-gray-600">{{ $appointments->procedure ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-center text-sm text-gray-600">{{ $appointments && $appointments->start ? \Carbon\Carbon::parse($appointments->start)->format('F j, Y') : 'N/A' }}</td>
                        <td class="px-4 py-2 text-center text-sm text-gray-600">
                            {{ $appointments && $appointments->start ? \Carbon\Carbon::parse($appointments->start)->format('h:i A') : 'N/A' }} - 
                            {{ $appointments && $appointments->end ? \Carbon\Carbon::parse($appointments->end)->format('h:i A') : 'N/A' }}
                        </td>
                        <td class="px-4 py-2 text-center text-sm text-gray-600"> <span id="estimated-time"></span></td>
                        <td class="px-4 py-2 text-center text-sm text-gray-600">₱<span id="procedure-price"></span></td>
                        <td class="px-4 py-2 text-center text-sm text-gray-600"><span id=""></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Total and Footer -->
        <div class="flex flex-col md:flex-row justify-between mt-6 border-t pt-4">
            <div class="text-sm text-gray-500">
                <p>• {{ $appointments && $appointments->created_at ? $appointments->created_at->diffForHumans() : 'N/A' }}</p>
            </div>
            <div class="text-right mt-2 md:mt-0">
                <p class="text-lg font-semibold text-gray-700">Total: ₱<span id="procedure-price2"></span></p>
            </div>
        </div>
    </div>
</div>
    

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let procedureName = "{{ $appointments->procedure ?? '' }}";

                        if (procedureName) {
                            fetch(`/get-procedure-details?procedure=${encodeURIComponent(procedureName)}`)
                                .then(response => response.json())
                                .then(data => {
                                    document.getElementById("estimated-time").textContent = data.duration;
                                    document.getElementById("procedure-price").textContent = data.price;
                                    document.getElementById("procedure-price2").textContent = data.price;
                                })
                                .catch(error => console.error("Error fetching procedure details:", error));
                        }
                    });
                </script>
        </div>
    </div>
    
            
                


   

</x-app-layout>
