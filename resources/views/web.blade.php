<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gatway</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="p-20 w-full max-xl:p-8 max-md:p-0">
        <div class="shadow-lg rounded-xl max-md:shadow-none">
            <div class=" bg-blue-500 rounded-xl max-md:rounded-none max-md:fixed max-md:w-full max-md:z-10">
                <div class="flex gap-2.5 py-4 px-14  items-center max-md:px-5 max-md:py-3">
                    <img
                        src="{{ asset('public/web/logo.svg') }}"
                        class="bg-white p-2.5 max-h-12 w-12 max-w-16 rounded-xl"
                        alt="LOgo">
    
                    <div class="text-base max-sm:text-sm font-semibold text-white ">
                        <p>atomic.softlancer.pay</p>
                        <p>Order Id: {{$data['orderId']}}</p>
                    </div>
                </div>    
            </div>
    
            <div class="grid grid-cols-2 max-md:grid-cols-1 max-md:top-[72px] max-md:relative">
                <!-- Left Section (Payment Methods) -->
                <div class="bg-gray-100 rounded-lg p-6 max-md:px-4 max-md:py-4">
                    <h3 class="text-gray-700 text-sm font-semibold mb-4">Select Payment Method</h3>
                    <div class="space-y-4 max-md:grid max-md:grid-cols-2 max-md:gap-2.5 max-md:space-y-0">
                        @foreach ($banks as $key => $item)
                            <button
                                class="flex items-center w-full p-3 max-md:p-2 bg-white rounded-lg shadow-sm text-gray-800 border border-transparent hover:border-blue-400 outline-none transition-all max-md:rounded"
                                id="button-{{$key}}"
                                onclick="change('{{ $key }}')"
                            >
                                <img src="https://via.placeholder.com/20" alt="UPI" class="mr-3">
                                <span class="uppercase">{{ $key }}</span>
                            </button>    
                        @endforeach
                    </div>                    
                </div>
    
                <!-- Right Section (Card Payment) -->
                <div class="rounded-lg p-6 max-md:py-4 max-md:px-4">
                    <!-- UPI Payment Section -->
                    @if (isset($banks['upi']) && $banks['upi'])
                        <div 
                            id="upi" 
                            class="hidden"
                        >
                            <h3 class="text-gray-700 text-sm font-semibold mb-4 max-md:text-base">Pay Using UPI</h3>

                            <form
                                action="{{ route('storeUpidata') }}"
                                method="POST"
                            >
                                @csrf
                                <div class="w-full flex flex-col gap-10 max-md:gap-4">
                                    <div class="flex flex-col justify-center items-center">
                                        <!-- Display the QR code -->
                                        <div class="[&>*]:max-w-44 [&>*]:max-h-44">
                                            {!! $qrCode !!}
                                        </div>
            
                                        <div class="flex flex-col justify-center">
                                            <p class="text-xl text-center font-bold text-gray-900 max-md:hidden">
                                                Pay Using
                                            </p>
            
                                            <div class="flex gap-2.5 my-2.5">
                                                {{-- <img src="{{ asset('public/web/phonepay.png') }}" class="max-md:max-h-10 max-md:max-w-10" alt="phone Pay">
            
                                                <img src="{{ asset('public/web/googlepay.png') }}" class="max-md:max-h-10 max-md:max-w-10" alt="Google Pay">
            
                                                <img src="{{ asset('public/web/paytm.png') }}" class="max-md:max-h-10 max-md:max-w-10" alt="Paytm Pay"> --}}
                                                {{$banks['upi']->upi_id}}
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="flex flex-col gap-3">
                                        <div class="flex gap-4 max-md:flex-col border-b border-gray-200 pb-2.5 max-md:border-none max-md:gap-2.5">
                                            <div class="w-full">
                                                <input
                                                    type="hidden"
                                                    name="type"
                                                    value="upi"
                                                >
                                                <input
                                                    type="hidden"
                                                    name="company_id"
                                                    value="{{$data['companyId'] ?? ''}}"
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
                                                        class="mb-1.5 w-full rounded-sm border border-gray-300 px-3 py-2 text-sm text-gray-900 hover:border-gray-500 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm {{$data['orderId'] ? 'bg-gray-200 !text-gray-400 cursor-not-allowed	' : ''}}"
                                                        placeholder="Enter Order ID"
                                                        required
                                                        maxlength="20"
                                                        {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                        aria-label="Order ID"
                                                        value="{{$data['orderId'] ?? ''}}"
                                                        {{$data['orderId'] ? 'readonly' : ''}}
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
                                                        class="mb-1.5 w-full rounded-sm border border-gray-300 px-3 py-2 text-sm text-gray-900 hover:border-gray-500 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm {{$data['amount'] ? 'bg-gray-200 !text-gray-400 cursor-not-allowed	' : ''}}"
                                                        placeholder="Enter Order ID"
                                                        required
                                                        maxlength="20"
                                                        {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                        aria-label="Amount"
                                                        value="{{$data['amount'] ?? ''}}"
                                                        {{$data['amount'] ? 'readonly' : ''}}
                                                    >
                                                </div>
                                            </div>

                                            <div class="flex justify-end md:hidden max-sm:justify-normal">
                                                <button
                                                    class="bg-blue-600 text-white max-sm:w-full py-2.5 px-6 rounded-md hover:bg-blue-700 max-md:rounded"
                                                    type="submit"
                                                >
                                                    Save Details
                                                </button>
                                            </div>
                                        </div>
        
                                        <div class="flex justify-end max-md:hidden">
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
                    @endif

                    @if (isset($banks['bank_service']) && $banks['bank_service'])
                        <div
                            id="bank_service"
                            class="hidden"
                        >
                            <form
                                action="{{ route('storeUpidata') }}"
                                method="POST"
                            >
                                @csrf
                                <div class="w-full flex flex-col gap-4">
                                    <h3 class="text-gray-700 text-sm font-semibold mb-4 max-md:text-base">Pay Using Bank Service</h3>

                                    <div class="flex flex-col gap-3 max-md:gap-2.5">
                                        <div class="w-full">
                                            <input
                                                type="hidden"
                                                name="type"
                                                value="bank_service"
                                            >
                                            <input
                                                type="hidden"
                                                name="company_id"
                                                value="{{$data['companyId'] ?? ''}}"
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
                                                    class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm {{$banks['bank_service']->account_no ? 'bg-gray-200 !text-gray-400 cursor-not-allowed	' : ''}}"
                                                    placeholder="Enter Account Number"
                                                    required
                                                    maxlength="18"
                                                    {{-- pattern="\d{9,18}" --}}
                                                    aria-label="Account Number"
                                                    value="{{$banks['bank_service']->account_no ?? ''}}"
                                                    {{$banks['bank_service']->account_no ? 'readonly' : ''}}
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
                                                    class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm {{$banks['bank_service']->ifsc_code ? 'bg-gray-200 !text-gray-400 cursor-not-allowed	' : ''}}"
                                                    placeholder="Enter IFSC Code"
                                                    required
                                                    maxlength="11"
                                                    {{-- pattern="^[A-Za-z]{4}\d{7}$" --}}
                                                    aria-label="IFSC Code"
                                                    value="{{$banks['bank_service']->ifsc_code ?? ''}}"
                                                    {{$banks['bank_service']->ifsc_code ? 'readonly' : ''}}
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
                                                    class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm {{$banks['bank_service']->account_holderName ? 'bg-gray-200 !text-gray-400 cursor-not-allowed	' : ''}}"
                                                    placeholder="Enter Account Holder Name"
                                                    required
                                                    maxlength="50"
                                                    aria-label="Account Holder Name"
                                                    value="{{$banks['bank_service']->account_holderName ?? ''}}"
                                                    {{$banks['bank_service']->account_holderName ? 'readonly' : ''}}
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
                                                    class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm {{$data['orderId'] ? 'bg-gray-200 !text-gray-400 cursor-not-allowed	' : ''}}"
                                                    placeholder="Enter Order ID"
                                                    required
                                                    maxlength="20"
                                                    {{-- pattern="^[A-Za-z0-9]{6,20}$" --}}
                                                    aria-label="Order ID"
                                                    value="{{$data['orderId'] ?? ''}}"
                                                    {{$data['orderId'] ? 'readonly' : ''}}
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
                                                    class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm {{$data['amount'] ? 'bg-gray-200 !text-gray-400 cursor-not-allowed	' : ''}}"
                                                    placeholder="Enter Amount"
                                                    required
                                                    aria-label="Amount"
                                                    value="{{$data['amount'] ?? ''}}"
                                                    {{$data['amount'] ? 'readonly' : ''}}
                                                >
                                            </div>
                                        </div>

                                        <div class="flex justify-end md:hidden">
                                            <button
                                                type="submit"
                                                class="bg-blue-600 text-white max-sm:w-full max-md:rounded py-2.5 px-6 rounded-md hover:bg-blue-700"
                                            >
                                                Save Details
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex justify-end max-md:hidden">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        });
    
        // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U (View Source), Ctrl+Shift+C (Inspect Element)
        document.addEventListener('keydown', function(event) {
        if (event.key === 'F12') {
            event.preventDefault();
        }
    
        // Disable Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C, Ctrl+U
        if (event.ctrlKey && (event.shiftKey && (event.key === 'I' || event.key === 'J' || event.key === 'C')) || event.key === 'U') {
            event.preventDefault();
        }
        });
    
        // Optional: Block other methods to prevent the developer tools from being opened
        document.addEventListener('keyup', function(event) {
        // Disable Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C, Ctrl+U on keyup as well
        if (event.ctrlKey && (event.shiftKey && (event.key === 'I' || event.key === 'J' || event.key === 'C')) || event.key === 'U') {
            event.preventDefault();
        }
        });
    </script>
  
    <script type="text/javascript">
        window.onload = function () {
            var type = @json(array_key_first($banks));
            document.getElementById(type).classList.remove('hidden');
            document.getElementById('button-'+type).classList.add('border-2', 'border-blue-400');
        };
        function change(params) {
            const elements =  @json(array_keys($banks));            
            
            elements.forEach(element => {
                document.getElementById(element).classList.add('hidden');
                document.getElementById('button-' + element).classList.remove('border-2', 'border-blue-400');
            });

            if (params) {
                document.getElementById(params).classList.remove('hidden');                
                document.getElementById('button-' + params).classList.add('border-2', 'border-blue-400');
            }
        }
    </script>
</html>