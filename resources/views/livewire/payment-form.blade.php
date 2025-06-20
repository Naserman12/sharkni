<div class=" max-w-md mx-auto bg-gradient-to-r from-orange-200 to-yellow-100 text-gray-800  rounded-xl shadow-md overflow-hidden md:max-w-2xl p-6"
x-data="{ paymentMethod: @entangle('paymentMethod').defer }">
<!-- title -->
 @php 
        app()->setLocale(session('lang')); //تعين اللغة بناء على المستخدم
        session()->put(['locale' => session('language')]); // تخزين اللغة في الجلسة
 @endphp
<h2 class="text-2xl font-bold text-gray-800 mb-6">إتمام عملية الدفع</h2>
        <!-- messages -->
        @if (session('message'))
        <div class=" mb-4 p-2 bg-green-200 text-green-700">
        {{ session('message') }} 
        </div>
        @endif
        @if (session('success'))
        <div class=" mb-4 p-2 bg-green-200 text-green-700">
        {{ session('success') }} 
        </div>
        @endif
        @if (session('payment'))
        <div class=" mb-4 p-2 bg-green-200 text-green-700">
        {{ session('payment') }} 
        </div>
        @endif
        
        @error('payment')  <span class="text-red-500 bg-red-100">{{$message}}</span> @enderror
       @if (session()->has('paystack_reference'))
           <div class=" mb-4 p-4 bg-violet-100 text-blue-600 rounded-lg">
            u have order if <a href="{{ session('paystack_reference_redirect_url') }}" >Click Here</a>
           </div>
       @endif
       <!-- order info -->
        <div class="mb-6 p-4 border border-gray-200 rounded-lg">
            <h3 class=" text-lg font-semibold text-gray-700 mb-2">Order info</h3>
            <p class="text-gray-600">Tool No: {{ $toolId }}</p>
            <p class="text-gray-600">Rental No: {{ $rentalId }}</p>
        </div>

        @if (!$paymentCompleted)
            <!-- Chose payment Type -->
             <div class="mb-6">
                <label class=" block text-gray-700 font-semibold mb-2">Type Payment</label>
                  <div class=" flex space-x-4">
                     <label class="inline-flex items-center hover:underline">
                        <input type="radio" wire:model.lazy="paymentType" value="full" class="form-radio text-indigo-600">
                        <span class=" ml-2">Pay Full</span>
                     </label>
                     <label class="inline-flex items-center hover:underline">
                        <input type="radio" wire:model="paymentType" value="deposit" class="form-radio text-indigo-600">
                        <span class=" ml-2">Pay deposit</span>
                     </label>
                  </div>
             </div>
             <!-- chose Payment method -->
            <div class="mb-6">
                 <label class="block text-gray-700 font-semibold mb-2">Payment method</label>
                 <div class=" grid grid-cols-2 gap-1">
                    <!-- Paystack -->
                <div @click="paymentMethod = 'paystack'; $wire.paymentMethod = 'paystack'" :class="{ 'ring-2 ring-indigo-500': paymentMethod === 'paystack'}" class="p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-slate-50 transition ">
                         <div class="flex items-center">
                        <input type="radio" wire:model="paymentMethod" value="paystack" class=" form-radio text-indigo-600">
                        <img src="#" alt="Paystack" class=" h-8 ml-2">
                         </div>
                    <p class=" mt2 text-sm text-gray-800">Pay With Paystack</p>
                </div>
                <!-- BAnk Transfer -->
                 <div @click="paymentMethod = 'bank_transfer'; $wire.paymentMethod = 'bank_transfer'" :class="{ 'ring-2 ring-indigo-500': paymentMethod === 'bank_transfer'}" class="p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-slate-50 transition ">
                    <div class="flex items-center">
                        <input type="radio" wire:model="paymentMethod" value="bank_transfer" class=" form-radio text-indigo-600">
                        <!-- <img src="#" alt="Bank_transfer" class=" h-8 ml-2"> -->
                      <i class="fas fa-bank-transfer"></i>
                    </div>
                    <p class=" mt2 text-sm text-gray-800">Bank Transfer</p>
                </div>
            </div>
        </div>
        <!-- Bank info  -->
        <p><span class="font-medium">Amount: </span>{{ number_format($amount ?? 0, 2)}}  NGN </p><hr>
         <div x-show="paymentMethod === 'bank_transfer' && $wire.showBankDetails" class=" mb6 p4 bg-yellow-100 rounded-lg">
                <!-- <h3 class=" text-lg font-semibold text-gray-800 mb-2 ml-1" >Bank Info</h3>
                <div class=" space-y-2 ml-1">
                    <p><span class="font-medium">Bank Name: </span>Wema</p>
                    <p><span class="font-medium">Acount Name:</span>Sharkni</p>
                    <p><span class="font-medium">Account No:</span> 0000000000</p>
                </div> -->
                @if ($paymentMethod === 'bank_transfer') 
                <!-- Upload Proof -->
                 <div class="mt-4">
                    <label class=" block text-gray-800 font-medium hidden">Upload proof</label> 
                    <input type="file" wire:model="bankReceipt" class="block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4 file:rounded-md file:font-semibold
                           file:text-sm file:bg-indigo-50 file:text-indigo-700
                           hover:file:bg-indigo-200 hidden">
                           @error('bankReceipt')  <span class="text-red-500 bg-red-100">{{$message}}</span> @enderror
                 </div>
                 <button wire:click="uploadBankReceipt"
                 class=" mt-4 w-full bg-indigo-600 text-gray-20 py-2 px-4 rounded-md hover:bg-indigo-700 transition" disable>
                 {{ app()->getLocale() == 'ha' ? 'Ana aiki a ki' : 'Temporarily disabled' }}
                </button>
                @endif 
            </div>
            <!-- Cuntenue to pay -->
            @if ( $paymentMethod === 'paystack')   
             <button wire:click="initiatePayment"
             class=" mt-4 w-full bg-yellow-800 text-gray-50 py-2 px-4 rounded-md hover:bg-yellow-950 transition">
             Contenue To Pay 
            </button>
            @endif
        @else
            <!-- Pament Success Message -->
             <div class="p-4rounded-lg border bg-green-100">
                <div class=" flex items-center">
                    <svg class="h-6 w-6 text-green-600" file="nono" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1314 4L19 7"></path>
                    </svg>
                    <h3 class=" ml-2 text-lg font-semibold text-green-700">
                        We have recived the order
                    </h3>
                </div>
                <p class=" mt-2 text-green-600">
                    @if ($paymentMethod === 'bank_transfer')
                        we'll return to u in 24H
                    @else
                        To see Your Order Check The dashboard
                    @endif
                </p>
                <a href="{{ route('dashboard') }}">
                    Go to dashboard
                </a>
             </div>
        @endif
</div>