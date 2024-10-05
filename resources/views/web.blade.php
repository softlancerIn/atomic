<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gatway</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="p-20 w-full shadow">
        <div class="shadow-lg rounded-xl">
            <div class=" bg-blue-500 rounded-xl">
                <div class="flex gap-2.5 py-4 px-14  items-center">
                    <img
                        src="{{ asset('public/web/logo.svg') }}"
                        class="bg-white p-2.5 max-h-12 w-12 max-w-16 rounded-xl"
                        alt="LOgo">
    
                    <div class="text-base font-semibold text-white ">
                        <p>atomic.softlancer.pay</p>
                        <p>Order Id: 1234567890</p>
                    </div>
                </div>    
            </div>
    
            <div class="grid grid-cols-2">
                <!-- Left Section (Payment Methods) -->
                <div class="bg-gray-100 rounded-lg p-6">
                    <h3 class="text-gray-700 text-sm font-semibold mb-4">Select Payment Method</h3>
                    <div class="space-y-4">
                        <button
                            class="flex items-center w-full p-3 bg-white rounded-lg shadow-sm text-gray-800 border border-transparent hover:border-blue-400 outline-none transition-all"
                            id="button-upi"
                            onclick="change('upi')"
                        >
                            <img src="https://via.placeholder.com/20" alt="UPI" class="mr-3">
                            <span>UPI</span>
                        </button>
                    
                        <button
                            class="flex items-center w-full p-3 bg-white rounded-lg shadow-sm text-gray-800 border border-transparent hover:border-blue-400 outline-none transition-all"
                            id="button-imps"
                            onclick="change('imps')"
                        >
                            <img src="https://via.placeholder.com/20" alt="IMPS" class="mr-3">
                            <span>IMPS</span>
                        </button>
                    
                        <button
                            class="flex items-center w-full p-3 bg-white rounded-lg shadow-sm text-gray-800 border border-transparent hover:border-blue-400 outline-none transition-all"
                            id="button-neft"
                            onclick="change('neft')"
                        >
                            <img src="https://via.placeholder.com/20" alt="NEFT" class="mr-3">
                            <span>NEFT</span>
                        </button>
                    
                        <button
                            class="flex items-center w-full p-3 bg-white rounded-lg shadow-sm text-gray-800 border border-transparent hover:border-blue-400 outline-none transition-all"
                            id="button-rtgs"
                            onclick="change('rtgs')"
                        >
                            <img src="https://via.placeholder.com/20" alt="RTGS" class="mr-3">
                            <span>RTGS</span>
                        </button>
                    </div>                    
                </div>
    
                <!-- Right Section (Card Payment) -->
                <div class="rounded-lg p-6">
                    <!-- UPI Payment Section -->
                    <div id="upi">
                        <h3 class="text-gray-700 text-sm font-semibold mb-4">Pay Using UPI</h3>

                        <form
                            action="{{ route('storeUpidata') }}"
                            method="POST"
                        >
                            @csrf
                            <div class="w-full flex flex-col gap-10 max-md:gap-4">
                                <div class="flex flex-col justify-center items-center">
                                    {!! $qrCode !!}
        
                                    <div class="flex flex-col justify-center">
                                        <p class="text-xl text-center font-bold text-gray-900">
                                            Pay Using
                                        </p>
        
                                        <div class="flex gap-2.5">
                                            <img src="{{ asset('public/web/phonepay.png') }}" alt="phone Pay">
        
                                            <img src="{{ asset('public/web/googlepay.png') }}" alt="Google Pay">
        
                                            <img src="{{ asset('public/web/paytm.png') }}" alt="Paytm Pay">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="flex flex-col gap-3">
                                    <div class="flex gap-4 max-md:flex-col border-b border-gray-200 pb-2.5">
                                        <div class="w-full">
                                            <input
                                                type="hidden"
                                                name="type"
                                                value="upi"
                                            >
                                            <label
                                                for="ref_no"
                                                class="block text-sm font-medium leading-6 text-gray-900"
                                            >
                                                UTR/Ref No
                                            </label>
            
                                            <div class="mt-2">
                                                <input
                                                    type="text"
                                                    name="ref_no"
                                                    id="ref_no"
                                                    autocomplete="off"
                                                    class="mb-1.5 w-full rounded-sm border border-gray-300 px-3 py-2 text-sm text-gray-900 hover:border-gray-500 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                    placeholder="Enter UTR/Reference Number"
                                                    required
                                                    maxlength="22"
                                                    {{-- pattern="^[A-Za-z0-9]{8,22}$" --}}
                                                    aria-label="UTR/Reference Number"
                                                >
                                            </div>
                                        </div>
    
                                        <div class="w-full">
                                            <label
                                                for="order_id"
                                                class="block text-sm font-medium leading-6 text-gray-900"
                                            >
                                                Order ID
                                            </label>
            
                                            <div class="mt-2">
                                                <input
                                                    type="text"
                                                    name="order_id"
                                                    id="order_id"
                                                    autocomplete="off"
                                                    class="mb-1.5 w-full rounded-sm border border-gray-300 px-3 py-2 text-sm text-gray-900 hover:border-gray-500 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                    placeholder="Enter Order ID"
                                                    required
                                                    maxlength="20"
                                                    {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                    aria-label="Order ID"
                                                >
                                            </div>
                                        </div>
    
                                        <div class="w-full">
                                            <label
                                                for="amount"
                                                class="block text-sm font-medium leading-6 text-gray-900"
                                            >
                                                Amount
                                            </label>
            
                                            <div class="mt-2">
                                                <input
                                                    type="text"
                                                    name="amount"
                                                    id="amount"
                                                    autocomplete="off"
                                                    class="mb-1.5 w-full rounded-sm border border-gray-300 px-3 py-2 text-sm text-gray-900 hover:border-gray-500 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                    placeholder="Enter Order ID"
                                                    required
                                                    maxlength="20"
                                                    {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                    aria-label="Amount"
                                                >
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="flex justify-end">
                                        <button
                                            class="bg-blue-600 text-white py-2.5 px-6 rounded-md hover:bg-blue-700"
                                            type="submit"
                                        >
                                            Save Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div
                        id="imps"
                        class="hidden"
                    >
                        <form
                            action="{{ route('storeUpidata') }}"
                            method="POST"
                        >
                        @csrf
                            <div class="w-full flex flex-col gap-4">
                                <h3 class="text-gray-700 text-sm font-semibold mb-4">Pay Using IMPS</h3>

                            
                                <div class="flex flex-col gap-3">
                                    <div class="w-full">
                                        <input
                                            type="hidden"
                                            name="type"
                                            value="imps"
                                        >

                                        <label
                                            for="account_no"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Account No
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="account_no"
                                                id="account_no"
                                                autocomplete="off"
                                                inputmode="numeric"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Account Number"
                                                required
                                                maxlength="18"
                                                {{-- pattern="\d{9,18}" --}}
                                                aria-label="Account Number"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label for="ifsc_code" class="block text-sm font-medium leading-6 text-gray-900">IFSC Code</label>
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="ifsc_code"
                                                id="ifsc_code"
                                                autocomplete="off"
                                                inputmode="text"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter IFSC Code"
                                                required
                                                maxlength="11"
                                                {{-- pattern="^[A-Za-z]{4}\d{7}$" --}}
                                                aria-label="IFSC Code"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="holder_name"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Account Holder Name
                                        </label>
        
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="holder_name"
                                                id="holder_name"
                                                autocomplete="name"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Account Holder Name"
                                                required
                                                maxlength="50"
                                                aria-label="Account Holder Name"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="ref_no"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            UTR/Ref No
                                        </label>
        
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="ref_no"
                                                id="ref_no"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter UTR/Reference Number"
                                                required
                                                maxlength="22"
                                                {{-- pattern="^[A-Za-z0-9]{8,22}$" --}}
                                                aria-label="UTR/Reference Number"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="order_id"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Order ID
                                        </label>
        
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="order_id"
                                                id="order_id"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Order ID"
                                                required
                                                maxlength="20"
                                                {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                aria-label="Order ID"
                                            >
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label
                                            for="amount"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Amount
                                        </label>
        
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="amount"
                                                id="amount"
                                                autocomplete="name"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Account Holder Name"
                                                required
                                                maxlength="50"
                                                aria-label="Account Amount"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="bg-blue-600 text-white py-2.5 px-6 rounded-md hover:bg-blue-700"
                                    >
                                        Save Details
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div
                        id="neft"
                        class="hidden"
                    >
                        <form
                            action="{{ route('storeUpidata') }}"
                            method="POST"
                        >
                            @csrf
                            <div class="w-full flex flex-col gap-4">
                                <h3 class="text-gray-700 text-sm font-semibold mb-4">Pay Using NEFT</h3>

                                <div class="flex flex-col gap-3">
                                    <div class="w-full">
                                        <input
                                            type="hidden"
                                            name="type"
                                            value="neft"
                                        >

                                        <label
                                            for="account_no"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Account No
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="account_no"
                                                id="account_no"
                                                autocomplete="off"
                                                inputmode="numeric"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Account Number"
                                                required
                                                maxlength="18"
                                                {{-- pattern="\d{9,18}" --}}
                                                aria-label="Account Number"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label for="ifsc_code" class="block text-sm font-medium leading-6 text-gray-900">IFSC Code</label>
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="ifsc_code"
                                                id="ifsc_code"
                                                autocomplete="off"
                                                inputmode="text"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter IFSC Code"
                                                required
                                                maxlength="11"
                                                {{-- pattern="^[A-Za-z]{4}\d{7}$" --}}
                                                aria-label="IFSC Code"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="holder_name"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Account Holder Name
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="holder_name"
                                                id="holder_name"
                                                autocomplete="name"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Account Holder Name"
                                                required
                                                maxlength="50"
                                                aria-label="Account Holder Name"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="ref_no"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            UTR/Ref No
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="ref_no"
                                                id="ref_no"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter UTR/Reference Number"
                                                required
                                                maxlength="22"
                                                {{-- pattern="^[A-Za-z0-9]{8,22}$" --}}
                                                aria-label="UTR/Reference Number"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="order_id"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Order ID
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="order_id"
                                                id="order_id"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Order ID"
                                                required
                                                maxlength="20"
                                                {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                aria-label="Order ID"
                                            >
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label
                                            for="amount"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Amount
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="amount"
                                                id="amount"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Amount"
                                                required
                                                aria-label="Amount"
                                            >
                                        </div>
                                    </div>
                                </div>
                                </form>

                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="bg-blue-600 text-white py-2.5 px-6 rounded-md hover:bg-blue-700"
                                    >
                                        Save Details
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div
                        id="rtgs"
                        class="hidden"
                    >
                        <form
                            action="{{ route('storeUpidata') }}"
                            method="POST"
                        >
                            @csrf
                            <div class="w-full flex flex-col gap-4">
                                <h3 class="text-gray-700 text-sm font-semibold mb-4">Pay Using RTGS</h3>

                                <div class="flex flex-col gap-3">
                                    <div class="w-full">
                                        <input
                                            type="hidden"
                                            name="type"
                                            value="neft"
                                        >

                                        <label
                                            for="account_no"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Account No
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="account_no"
                                                id="account_no"
                                                autocomplete="off"
                                                inputmode="numeric"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Account Number"
                                                required
                                                maxlength="18"
                                                {{-- pattern="\d{9,18}" --}}
                                                aria-label="Account Number"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label for="ifsc_code" class="block text-sm font-medium leading-6 text-gray-900">IFSC Code</label>
                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="ifsc_code"
                                                id="ifsc_code"
                                                autocomplete="off"
                                                inputmode="text"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter IFSC Code"
                                                required
                                                maxlength="11"
                                                {{-- pattern="^[A-Za-z]{4}\d{7}$" --}}
                                                aria-label="IFSC Code"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="holder_name"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Account Holder Name
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="holder_name"
                                                id="holder_name"
                                                autocomplete="name"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Account Holder Name"
                                                required
                                                maxlength="50"
                                                aria-label="Account Holder Name"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="ref_no"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            UTR/Ref No
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="ref_no"
                                                id="ref_no"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter UTR/Reference Number"
                                                required
                                                maxlength="22"
                                                {{-- pattern="^[A-Za-z0-9]{8,22}$" --}}
                                                aria-label="UTR/Reference Number"
                                            >
                                        </div>
                                    </div>
                            
                                    <div class="w-full">
                                        <label
                                            for="order_id"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Order ID
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="order_id"
                                                id="order_id"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Order ID"
                                                required
                                                maxlength="20"
                                                {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                aria-label="Order ID"
                                            >
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label
                                            for="amount"
                                            class="block text-sm font-medium leading-6 text-gray-900"
                                        >
                                            Amount
                                        </label>

                                        <div class="mt-2">
                                            <input
                                                type="text"
                                                name="amount"
                                                id="amount"
                                                autocomplete="off"
                                                class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                                                placeholder="Enter Amount"
                                                required
                                                aria-label="Amount"
                                            >
                                        </div>
                                    </div>
                                </div>
                                </form>

                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="bg-blue-600 text-white py-2.5 px-6 rounded-md hover:bg-blue-700"
                                    >
                                        Save Details
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script type="text/javascript">
        function change(params) {
            const elements = ['upi', 'imps', 'rtgs', 'neft'];
            
            elements.forEach(element => {
                document.getElementById(element).classList.add('hidden');
                document.getElementById('button-' + element).classList.remove('border', 'border-blue-300');
            });

            if (params) {
                // Show the selected element and add border classes to the corresponding button
                document.getElementById(params).classList.remove('hidden');
                document.getElementById('button-' + params).classList.add('border', 'border-blue-400');
            }
        }
    </script>
</html>