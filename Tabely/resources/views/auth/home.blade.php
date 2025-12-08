<x-layout>
 <div class="w-screen h-screen bg-white flex flex-row">
     {{--menu side--}}
     <div class="flex-2 w-full h-full bg-orange-50/90" >
         {{--menu--}}
         <div class="w-full h-full flex flex-col gap-10 items-center py-10">
             {{--profile picking--}}
             <label class="text-3xl">Picked Profile:</label>
             <div class="relative w-[calc(80%)] hover:scale-95 transition-transform focus:scale-95">
                <select id="profile" name="profile" style="text-align-last: center" class="font-light block py-1 rounded-3xl w-full appearance-none bg-orange-100 border-2 border-black focus:border-transparent focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                    <option value="{{$pickedProfile}}">{{ $pickedProfile->name }}:  {{ $pickedProfile->standing_height }}cm/{{ $pickedProfile->sitting_height }}cm/{{ $pickedProfile->session_length }}min</option>
                    @foreach($profiles as $profile)
                        @continue($profile == $pickedProfile)
                        <option value="{{$profile}}">{{ $profile->name }} Standing height: {{ $profile->standing_height }} Sitting height: {{$profile->sitting_height}}</option>
                    @endforeach
                </select>
                 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                     <img src="{{ asset('images/drop-arrow.png') }}" class="size-3" alt="dropdown menu arrow">
                 </div>
             </div>
             {{--selecting sitting and standing height or automatically--}}
             <div class="flex flex-row gap-5">
                 {{--sitting height--}}
                 <button id="standingHeight" name="standingHeight" class="border-2 py-1 px-2 rounded-3xl border-black bg-orange-100 transition-transform hover:scale-95 hover:border-orange-500 active:bg-orange-200 active:scale-90 active:border-b-orange-600">
                    Standing height
                 </button>
                 {{--standing height--}}
                 <button id="sittingHeight" name="sittingHeight" class="border-2 py-1 px-2 rounded-3xl border-black bg-orange-100 transition-transform hover:scale-95 hover:border-orange-500 active:bg-orange-200 active:scale-90 active:border-b-orange-600">
                    Sitting Height
                 </button>
                 {{--adjust automaticaly--}}
                 <button id="adjustAuto" name="adjustAuto" class="border-2 py-1 px-2 rounded-3xl border-black bg-orange-100 transition-transform hover:scale-95 hover:border-orange-500 active:bg-orange-200 active:scale-90 active:border-b-orange-600">
                    Adjust automatically
                 </button>
             </div>

             {{--adjust manually--}}
             <div class="flex flex-col gap-5 items-center">
                 <label class="text-2xl">Current height:</label>
                 <div class="flex flex-row gap-5">
                     {{--minus button--}}
                     <button id="decrease" class="px-4 py-2 bg-orange-100 border-2 rounded-full border-gray-400 transition-transform hover:border-orange-500 hover:scale-95 active:scale-90 active:bg-orange-200 active:border-orange-600" type="button" onclick="this.nextElementSibling.stepDown()">
                        -
                     </button>
                     {{--height input--}}
                     <input id="height" name="height" type="number" value="{{ $currentHeight }}" style="text-align-last: center" class="[&::-webkit-inner-spin-button]:appearance-none &::-webkit-outer-spin-button]:appearance-none] appearance-none bg-white py-2 px-4 border-2 border-gray-400 rounded-3xl">
                     {{--plus Button--}}
                     <button id="increase" class="px-4 py-2 bg-orange-100 border-2 rounded-full border-gray-400 transition-transform hover:border-orange-500 hover:scale-95 active:scale-90 active:bg-orange-200 active:border-orange-600" type="button" onclick="this.previousElementSibling.stepUp()">
                        +
                     </button>
                 </div>
             </div>
         </div>
     </div>
     <div class="bg-gray-200 w-1 h-full"></div>
     {{--3D model--}}
     <div class="flex-2 w-full h-full">
        <div id="container3D" class="w-full h-full"></div>
     </div>
 </div>
</x-layout>
<script type="module" src="{{ asset('js/model3D.js') }}?v={{ filemtime(public_path('js/model3D.js')) }}"></script>
