@extends('layouts.layout')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4">
    <div class="max-w-6xl mx-auto">

        <!-- Heading -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Available Payment Options</h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Securely complete your payment using any of the following trusted methods.
            </p>
        </div>

        <!-- Payment card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            
            <!-- Tabs -->
            <div class="flex border-b border-gray-200 bg-gray-50">
                <button class="tab-btn active" data-tab="upi">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    UPI
                </button>
                <button class="tab-btn" data-tab="cards">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                    </svg>
                    Cards
                </button>
                <button class="tab-btn" data-tab="netbanking">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                    </svg>
                    Net Banking
                </button>
                <button class="tab-btn" data-tab="wallets">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                    Wallets
                </button>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- UPI -->
                <div id="upi" class="tab-content">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Pay via UPI</h3>
                        <p class="text-gray-600">Instant payment using UPI apps</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Google Pay -->
                        <div class="payment-option">
                            <div class="payment-icon bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://cdn.worldvectorlogo.com/logos/gpay.svg" 
                                     alt="Google Pay" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/4285F4/FFFFFF?text=Google+Pay'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">Google Pay</p>
                            <p class="text-xs text-gray-500 text-center">Instant UPI Payment</p>
                        </div>
                        
                        <!-- PhonePe -->
                        <div class="payment-option">
                            <div class="payment-icon bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://logos-download.com/wp-content/uploads/2021/01/PhonePe_Logo.png" 
                                     alt="PhonePe" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/5F259F/FFFFFF?text=PhonePe'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">PhonePe</p>
                            <p class="text-xs text-gray-500 text-center">UPI & Wallet</p>
                        </div>
                        
                        <!-- Paytm -->
                        <div class="payment-option">
                            <div class="payment-icon bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://logos-download.com/wp-content/uploads/2021/01/Paytm_Logo.png" 
                                     alt="Paytm" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/00BAF2/FFFFFF?text=Paytm'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">Paytm</p>
                            <p class="text-xs text-gray-500 text-center">UPI & Wallet</p>
                        </div>
                        
                        <!-- BHIM -->
                        <div class="payment-option">
                            <div class="payment-icon bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://upload.wikimedia.org/wikipedia/en/thumb/9/9d/BHIM_Logo.png/240px-BHIM_Logo.png" 
                                     alt="BHIM UPI" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/00A699/FFFFFF?text=BHIM+UPI'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">BHIM UPI</p>
                            <p class="text-xs text-gray-500 text-center">NPCI UPI App</p>
                        </div>
                    </div>
                    
                    <!-- UPI ID Input -->
                    <div class="mt-10 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
                        <h4 class="font-semibold text-gray-800 mb-4">Enter UPI ID for Payment</h4>
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-grow">
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                       placeholder="Enter your UPI ID (e.g., 1234567890@upi)">
                            </div>
                            <button class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition duration-300 whitespace-nowrap">
                                Verify & Pay
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mt-3">Enter your UPI ID (mobile@bank) to proceed with payment</p>
                    </div>
                </div>

                <!-- Cards -->
                <div id="cards" class="tab-content hidden">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Credit & Debit Cards</h3>
                        <p class="text-gray-600">Pay using your Visa, Mastercard, RuPay or other cards</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Card Logos -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl">
                            <h4 class="font-semibold text-gray-800 mb-6">Accepted Cards</h4>
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Visa -->
                                <div class="card-logo">
                                    <div class="logo-container bg-white p-4 rounded-xl border border-gray-200">
                                        <img src="https://cdn.worldvectorlogo.com/logos/visa-1.svg" 
                                             alt="Visa" 
                                             class="h-10 mx-auto object-contain"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/200x60/1A1F71/FFFFFF?text=VISA'">
                                    </div>
                                    <p class="text-center text-sm font-medium mt-2">Visa</p>
                                </div>
                                
                                <!-- Mastercard -->
                                <div class="card-logo">
                                    <div class="logo-container bg-white p-4 rounded-xl border border-gray-200">
                                        <img src="https://cdn.worldvectorlogo.com/logos/mastercard-2.svg" 
                                             alt="Mastercard" 
                                             class="h-10 mx-auto object-contain"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/200x60/EB001B/FFFFFF?text=Mastercard'">
                                    </div>
                                    <p class="text-center text-sm font-medium mt-2">Mastercard</p>
                                </div>
                                
                                <!-- RuPay -->
                                <div class="card-logo">
                                    <div class="logo-container bg-white p-4 rounded-xl border border-gray-200">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/RuPay.svg/512px-RuPay.svg.png" 
                                             alt="RuPay" 
                                             class="h-10 mx-auto object-contain"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/200x60/0F5BA5/FFFFFF?text=RuPay'">
                                    </div>
                                    <p class="text-center text-sm font-medium mt-2">RuPay</p>
                                </div>
                                
                                <!-- American Express -->
                                <div class="card-logo">
                                    <div class="logo-container bg-white p-4 rounded-xl border border-gray-200">
                                        <img src="https://cdn.worldvectorlogo.com/logos/american-express-1.svg" 
                                             alt="American Express" 
                                             class="h-10 mx-auto object-contain"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/200x60/2E77BC/FFFFFF?text=Amex'">
                                    </div>
                                    <p class="text-center text-sm font-medium mt-2">Amex</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Form -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-6">Enter Card Details</h4>
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                    <div class="relative">
                                        <input type="text" 
                                               class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                               placeholder="1234 5678 9012 3456"
                                               maxlength="19">
                                        <div class="absolute left-3 top-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                        <input type="text" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                               placeholder="MM/YY">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                        <input type="text" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                               placeholder="123">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                                    <input type="text" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                           placeholder="Name on card">
                                </div>
                                
                                <div class="mt-8">
                                    <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition duration-300 shadow-lg">
                                        Pay Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Banking -->
                <div id="netbanking" class="tab-content hidden">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Net Banking</h3>
                        <p class="text-gray-600">Transfer directly from your bank account</p>
                    </div>
                    
                    <!-- Popular Banks -->
                    <div class="mb-10">
                        <h4 class="font-semibold text-gray-800 mb-6">Popular Banks</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <!-- SBI -->
                            <div class="bank-option">
                                <div class="bank-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cc/SBI-logo.svg/512px-SBI-logo.svg.png" 
                                         alt="SBI Bank" 
                                         class="h-12 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/2E3192/FFFFFF?text=SBI'">
                                </div>
                                <p class="mt-3 text-center font-medium text-gray-800">SBI</p>
                            </div>
                            
                            <!-- HDFC -->
                            <div class="bank-option">
                                <div class="bank-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/HDFC_Bank_Logo.svg/512px-HDFC_Bank_Logo.svg.png" 
                                         alt="HDFC Bank" 
                                         class="h-12 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/004C6F/FFFFFF?text=HDFC'">
                                </div>
                                <p class="mt-3 text-center font-medium text-gray-800">HDFC Bank</p>
                            </div>
                            
                            <!-- ICICI -->
                            <div class="bank-option">
                                <div class="bank-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/ICICI_Bank_Logo.svg/512px-ICICI_Bank_Logo.svg.png" 
                                         alt="ICICI Bank" 
                                         class="h-12 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/FF6B00/FFFFFF?text=ICICI'">
                                </div>
                                <p class="mt-3 text-center font-medium text-gray-800">ICICI Bank</p>
                            </div>
                            
                            <!-- Axis Bank -->
                            <div class="bank-option">
                                <div class="bank-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Axis_Bank_logo.svg/512px-Axis_Bank_logo.svg.png" 
                                         alt="Axis Bank" 
                                         class="h-12 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/D22630/FFFFFF?text=AXIS'">
                                </div>
                                <p class="mt-3 text-center font-medium text-gray-800">Axis Bank</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- All Banks Dropdown -->
                    <div class="mt-8">
                        <h4 class="font-semibold text-gray-800 mb-4">Select Your Bank</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                                    <option value="">Select your bank</option>
                                    <option value="sbi">State Bank of India</option>
                                    <option value="hdfc">HDFC Bank</option>
                                    <option value="icici">ICICI Bank</option>
                                    <option value="axis">Axis Bank</option>
                                    <option value="pnb">Punjab National Bank</option>
                                    <option value="kotak">Kotak Mahindra Bank</option>
                                    <option value="yes">Yes Bank</option>
                                    <option value="indusind">IndusInd Bank</option>
                                    <option value="bob">Bank of Baroda</option>
                                    <option value="canara">Canara Bank</option>
                                </select>
                            </div>
                            
                            <div>
                                <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition duration-300 shadow-lg">
                                    Continue to Net Banking
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-8 p-5 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-green-800 font-medium">Secure Net Banking</p>
                                    <p class="text-green-700 text-sm mt-1">You will be redirected to your bank's secure portal for payment authorization.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wallets -->
                <div id="wallets" class="tab-content hidden">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Digital Wallets</h3>
                        <p class="text-gray-600">Pay using your favorite digital wallet</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Paytm -->
                        <div class="wallet-option">
                            <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://cdn.worldvectorlogo.com/logos/paytm-1.svg" 
                                     alt="Paytm" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/00BAF2/FFFFFF?text=Paytm'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">Paytm Wallet</p>
                            <p class="text-xs text-gray-500 text-center">Wallet & UPI</p>
                        </div>
                        
                        <!-- PhonePe -->
                        <div class="wallet-option">
                            <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://logos-download.com/wp-content/uploads/2021/01/PhonePe_Logo.png" 
                                     alt="PhonePe" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/5F259F/FFFFFF?text=PhonePe'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">PhonePe</p>
                            <p class="text-xs text-gray-500 text-center">Wallet & UPI</p>
                        </div>
                        
                        <!-- Amazon Pay -->
                        <div class="wallet-option">
                            <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://cdn.worldvectorlogo.com/logos/amazon-pay-3.svg" 
                                     alt="Amazon Pay" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/FF9900/000000?text=Amazon+Pay'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">Amazon Pay</p>
                            <p class="text-xs text-gray-500 text-center">Amazon account</p>
                        </div>
                        
                        <!-- MobiKwik -->
                        <div class="wallet-option">
                            <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/MobiKwik_logo.svg/512px-MobiKwik_logo.svg.png" 
                                     alt="MobiKwik" 
                                     class="h-12 mx-auto object-contain"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150x60/E50A15/FFFFFF?text=MobiKwik'">
                            </div>
                            <p class="mt-3 text-center font-medium text-gray-800">MobiKwik</p>
                            <p class="text-xs text-gray-500 text-center">Wallet & UPI</p>
                        </div>
                    </div>
                    
                    <!-- More Wallets -->
                    <div class="mt-10">
                        <h4 class="font-semibold text-gray-800 mb-6">Other Wallets</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <!-- Freecharge -->
                            <div class="wallet-option">
                                <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f7/Freecharge_Logo.svg/512px-Freecharge_Logo.svg.png" 
                                         alt="Freecharge" 
                                         class="h-10 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/120x40/FF3266/FFFFFF?text=Freecharge'">
                                </div>
                                <p class="mt-2 text-center text-sm font-medium">Freecharge</p>
                            </div>
                            
                            <!-- JioMoney -->
                            <div class="wallet-option">
                                <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/JioMoney_Logo.svg/512px-JioMoney_Logo.svg.png" 
                                         alt="JioMoney" 
                                         class="h-10 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/120x40/0084FF/FFFFFF?text=JioMoney'">
                                </div>
                                <p class="mt-2 text-center text-sm font-medium">JioMoney</p>
                            </div>
                            
                            <!-- Ola Money -->
                            <div class="wallet-option">
                                <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/Ola_Money_Logo.svg/512px-Ola_Money_Logo.svg.png" 
                                         alt="Ola Money" 
                                         class="h-10 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/120x40/000000/FFFFFF?text=Ola+Money'">
                                </div>
                                <p class="mt-2 text-center text-sm font-medium">Ola Money</p>
                            </div>
                            
                            <!-- Airtel Money -->
                            <div class="wallet-option">
                                <div class="wallet-logo bg-white p-4 rounded-xl border border-gray-200">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/77/Airtel_Money_Logo.svg/512px-Airtel_Money_Logo.svg.png" 
                                         alt="Airtel Money" 
                                         class="h-10 mx-auto object-contain"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/120x40/E40000/FFFFFF?text=Airtel+Money'">
                                </div>
                                <p class="mt-2 text-center text-sm font-medium">Airtel Money</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Wallet Benefits -->
                    <div class="mt-10 p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                        <h4 class="font-semibold text-gray-800 mb-4">Why use Digital Wallets?</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Fast Checkout</p>
                                    <p class="text-sm text-gray-600 mt-1">Complete payment in seconds with saved payment methods</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                                        <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Cashback & Rewards</p>
                                    <p class="text-sm text-gray-600 mt-1">Earn cashback and reward points on every transaction</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Secure</p>
                                    <p class="text-sm text-gray-600 mt-1">Your card details are never shared with merchants</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Security Info -->
        <div class="mt-10 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-gray-800">100% Secure Payments</h4>
                        <p class="text-sm text-gray-600">All transactions are encrypted and secure</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="flex items-center mr-6">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-200 mr-3">
                            <span class="text-blue-600 font-bold text-xs">SSL</span>
                        </div>
                        <span class="text-sm text-gray-700">256-bit SSL</span>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-200 mr-3">
                            <span class="text-green-600 font-bold text-xs">PCI</span>
                        </div>
                        <span class="text-sm text-gray-700">PCI DSS</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Tab Switching
    const buttons = document.querySelectorAll(".tab-btn");
    const contents = document.querySelectorAll(".tab-content");

    // Initialize first tab
    buttons[0].classList.add("active");
    contents[0].classList.remove("hidden");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            // Reset all
            buttons.forEach(b => b.classList.remove("active"));
            contents.forEach(c => c.classList.add("hidden"));

            // Activate clicked
            this.classList.add("active");
            document.getElementById(this.dataset.tab).classList.remove("hidden");
        });
    });

    // Card number formatting
    const cardInput = document.querySelector('input[placeholder="1234 5678 9012 3456"]');
    if(cardInput) {
        cardInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formatted = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = formatted.substring(0, 19);
        });
    }

    // Add hover effects
    const options = document.querySelectorAll('.payment-option, .card-logo, .bank-option, .wallet-option');
    
    options.forEach(option => {
        option.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        option.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Image error handling
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            const altText = this.alt || 'Payment Option';
            const color = this.src.includes('Google') ? '4285F4' : 
                         this.src.includes('PhonePe') ? '5F259F' : 
                         this.src.includes('Paytm') ? '00BAF2' : 
                         this.src.includes('Visa') ? '1A1F71' : 
                         this.src.includes('Mastercard') ? 'EB001B' : 
                         this.src.includes('Amazon') ? 'FF9900' : '4F46E5';
            
            const textColor = this.src.includes('Amazon') ? '000000' : 'FFFFFF';
            this.src = `https://via.placeholder.com/150x60/${color}/${textColor}?text=${encodeURIComponent(altText)}`;
        });
    });

});
</script>

<style>
.tab-btn {
    padding: 16px 24px;
    font-weight: 600;
    color: #6b7280;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tab-btn:hover {
    color: #4f46e5;
    background-color: #f9fafb;
}

.tab-btn.active {
    color: #4f46e5;
    border-color: #4f46e5;
    background-color: white;
}

.tab-content {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.payment-option, .card-logo, .bank-option, .wallet-option {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.payment-icon, .bank-logo, .wallet-logo, .logo-container {
    transition: all 0.3s ease;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.payment-option:hover .payment-icon,
.bank-option:hover .bank-logo,
.wallet-option:hover .wallet-logo,
.card-logo:hover .logo-container {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    border-color: #c7d2fe;
    transform: scale(1.05);
}

.payment-option:hover,
.bank-option:hover,
.wallet-option:hover,
.card-logo:hover {
    transform: translateY(-5px);
}

/* Ensure images are properly sized */
.payment-icon img,
.bank-logo img,
.wallet-logo img,
.logo-container img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}
</style>

@endsection