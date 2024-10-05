<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gatway</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="shadow-lg m-10 bg-gray-100 p-12 max-md:p-4">
        <div class="flex flex-col items-center justify-center">
            <img class="max-h-10 max-w-10" src="{{asset('web/logo.svg')}}" alt="logo">

            <div class="text-2xl">Welcome to Atomic Gateway</div>
        </div>

        <form action="{{route('storeUpidata')}}" method="POST">
            @csrf
            <div class="pb-6">
                <div class="sm:col-span-3">
                    <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Select Payment Mode</label>
                    <div class="mt-2">
                        <select
                            id="country"
                            name="country"
                            autocomplete="country-name"
                            class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm"
                            onchange="showDiv(this)"
                        >
                            <option value="">--- Choose one --- </option>
                            <option value="upi">UPI</option>
                            <option value="imps">IMPS</option>
                            <option value="rtgs">RTGS</option>
                            <option value="neft">NEFT</option>
                        </select>
                    </div>
                </div>

                <div
                    id="upi"
                    class="hidden my-4 flex flex-col gap-6 border border-gray-300 p-5 rounded-lg"
                >
                    <div class="flex items-center justify-center">
                        <p class="text-2xl font-medium max-md:text-base">UPI Payment Mode</p>
                    </div>

                    <div class="w-full flex flex-col gap-10 max-md:gap-4">
                        <div class="flex flex-col justify-center items-center">
                            <img src="{{asset('web/qrpng.png')}}" alt="">

                            <div class="flex flex-col justify-center">
                                <p class="text-xl text-center font-bold text-gray-900">
                                    Pay Using
                                </p>

                                <div class="flex gap-2.5">
                                    <img src="{{asset('web/phonepay.png')}}" alt="phone Pay">

                                    <img src="{{asset('web/googlepay.png')}}" alt="Google Pay">

                                    <img src="{{asset('web/paytm.png')}}" alt="Paytm Pay">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex gap-4 max-md:flex-col">
                                <!-- UTR/Ref No -->
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
                                            pattern="^[A-Za-z0-9]{8,22}$"
                                            aria-label="UTR/Reference Number"
                                        >
                                    </div>
                                </div>
    
                                <!-- Transaction Slip -->
                                <div class="w-full">
                                    <label
                                        for="transaction_slip"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                    >
                                        Transaction Slip
                                    </label>
    
                                    <div class="mt-2">
                                        <input
                                            type="file"
                                            name="transaction_slip"
                                            id="transaction_slip"
                                            class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm bg-white"
                                            accept=".jpg,.jpeg,.png,.pdf"
                                            required
                                            aria-label="Transaction Slip"
                                        >
                                    </div>
                                </div>
                            </div>
    
                            <div class="flex gap-4 max-md:flex-col">
                                 <!-- Order ID -->
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
                                            pattern="^[A-Za-z0-9]{6,20}$"
                                            aria-label="Order ID"
                                        >
                                    </div>
                                </div>
    
                                 <!-- Order ID -->
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
                                            placeholder="Enter Order ID"
                                            required
                                            maxlength="20"
                                            pattern="^[A-Za-z0-9]{6,20}$"
                                            aria-label="Amount"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    id="imps"
                    class="hidden my-4 flex flex-col gap-6 border border-gray-300 p-5 rounded-lg"
                >
                    <div class="flex items-center justify-center">
                        <p class="text-2xl font-medium max-md:text-base">IMPS Payment Mode</p>
                    </div>

                    <div class="w-full">
                        <div class="flex gap-4">
                            <!-- Account Number Field -->
                            <div class="w-full">
                                <label for="account_no" class="block text-sm font-medium leading-6 text-gray-900">Account No</label>
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
                                        pattern="\d{9,18}"
                                        aria-label="Account Number"
                                    >
                                </div>
                            </div>
                    
                            <!-- IFSC Code Field -->
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
                                        pattern="^[A-Za-z]{4}\d{7}$"
                                        aria-label="IFSC Code"
                                    >
                                </div>
                            </div>
                        </div>
                    
                        <div class="flex gap-4">
                            <!-- Account Holder Name -->
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
                    
                            <!-- UTR/Ref No -->
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
                                        pattern="^[A-Za-z0-9]{8,22}$"
                                        aria-label="UTR/Reference Number"
                                    >
                                </div>
                            </div>
                        </div>
                    
                        <div class="flex gap-4">
                            <!-- Transaction Slip -->
                            <div class="w-full">
                                <label
                                    for="transaction_slip"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                >
                                    Transaction Slip
                                </label>

                                <div class="mt-2">
                                    <input
                                        type="file"
                                        name="transaction_slip"
                                        id="transaction_slip"
                                        class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm bg-white"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        required
                                        aria-label="Transaction Slip"
                                    >
                                </div>
                            </div>
                    
                            <!-- Order ID -->
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
                                        pattern="^[A-Za-z0-9]{6,20}$"
                                        aria-label="Order ID"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RTGS -->
                <div
                    id="rtgs"
                    class="hidden my-4 flex flex-col gap-6 border border-gray-300 p-5 rounded-lg"
                >
                    <div class="flex items-center justify-center">
                        <p class="text-2xl font-medium max-md:text-base">RTGS Payment Mode</p>
                    </div>

                    <div class="w-full">
                        <div class="flex gap-4">
                            <!-- Account Number Field -->
                            <div class="w-full">
                                <label for="account_no" class="block text-sm font-medium leading-6 text-gray-900">Account No</label>
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
                                        pattern="\d{9,18}"
                                        aria-label="Account Number"
                                    >
                                </div>
                            </div>
                    
                            <!-- IFSC Code Field -->
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
                                        pattern="^[A-Za-z]{4}\d{7}$"
                                        aria-label="IFSC Code"
                                    >
                                </div>
                            </div>
                        </div>
                    
                        <div class="flex gap-4">
                            <!-- Account Holder Name -->
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
                    
                            <!-- UTR/Ref No -->
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
                                        pattern="^[A-Za-z0-9]{8,22}$"
                                        aria-label="UTR/Reference Number"
                                    >
                                </div>
                            </div>
                        </div>
                    
                        <div class="flex gap-4">
                            <!-- Transaction Slip -->
                            <div class="w-full">
                                <label
                                    for="transaction_slip"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                >
                                    Transaction Slip
                                </label>

                                <div class="mt-2">
                                    <input
                                        type="file"
                                        name="transaction_slip"
                                        id="transaction_slip"
                                        class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm bg-white"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        required
                                        aria-label="Transaction Slip"
                                    >
                                </div>
                            </div>
                    
                            <!-- Order ID -->
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
                                        pattern="^[A-Za-z0-9]{6,20}$"
                                        aria-label="Order ID"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NEFT -->
                <div
                    id="neft"
                    class="hidden my-4 flex flex-col gap-6 border border-gray-300 p-5 rounded-lg"
                >
                    <div class="flex items-center justify-center">
                        <p class="text-2xl font-medium max-md:text-base">NEFT Payment Mode</p>
                    </div>

                    <div class="w-full">
                        <div class="flex gap-4">
                            <!-- Account Number Field -->
                            <div class="w-full">
                                <label for="account_no" class="block text-sm font-medium leading-6 text-gray-900">Account No</label>
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
                                        pattern="\d{9,18}"
                                        aria-label="Account Number"
                                    >
                                </div>
                            </div>
                    
                            <!-- IFSC Code Field -->
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
                                        pattern="^[A-Za-z]{4}\d{7}$"
                                        aria-label="IFSC Code"
                                    >
                                </div>
                            </div>
                        </div>
                    
                        <div class="flex gap-4">
                            <!-- Account Holder Name -->
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
                    
                            <!-- UTR/Ref No -->
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
                                        pattern="^[A-Za-z0-9]{8,22}$"
                                        aria-label="UTR/Reference Number"
                                    >
                                </div>
                            </div>
                        </div>
                    
                        <div class="flex gap-4">
                            <!-- Transaction Slip -->
                            <div class="w-full">
                                <label
                                    for="transaction_slip"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                >
                                    Transaction Slip
                                </label>

                                <div class="mt-2">
                                    <input
                                        type="file"
                                        name="transaction_slip"
                                        id="transaction_slip"
                                        class="mb-1.5 w-full rounded-sm border border-gray-200 px-3 py-2 text-sm text-zinc-500 hover:border-gray-400 outline-none transition-all max-md:py-2 max-sm:px-4 max-sm:py-2 max-sm:text-sm bg-white"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        required
                                        aria-label="Transaction Slip"
                                    >
                                </div>
                            </div>
                    
                            <!-- Order ID -->
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
                                        pattern="^[A-Za-z0-9]{6,20}$"
                                        aria-label="Order ID"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-x-6">
                <button
                    type="submit"
                    class="rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Pay Here
                </button>
            </div>
        </form>
    </div>
</body>
    <script type="text/javascript">
        function showDiv(select) {
            console.log(select.value);
            
            document.getElementById('upi').classList.add('hidden');
            document.getElementById('imps').classList.add('hidden');
            document.getElementById('rtgs').classList.add('hidden');
            document.getElementById('neft').classList.add('hidden');

            if (select.value) {
                document.getElementById(select.value).classList.remove('hidden');
            }
        }
    </script>
</html>