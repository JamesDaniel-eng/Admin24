<x-layouts.admin>
    <x-slot name="title">{{ trans('inventory::general.pot') }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans('inventory::general.pot') }}"
        icon="point_of_sale"
        route="inventory.pot.index"
    ></x-slot>

    <x-slot name="content">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.10.2/lottie.min.js"></script>

        <div class="grid grid-cols-1 grid-rows-3 md:grid-cols-2 gap-6 my-10 h-full">
            <!-- Create Production Transfer -->
            <a href="{{ route('inventory.pot.create', ['flow' => 'create']) }}" class="group row-span-1 row-start-2 md:row-span-1 md:row-start-1">
                <div class="p-8 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 border-l-4 border-l-blue-500 h-full">
                    <!-- Grid: 2fr content, 1fr icon -->
                    <div class="grid grid-cols-3 gap-6 items-center h-full">
                        <!-- Content Column -->
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                                {{ trans('inventory::general.pot_text.create_transfer') }}
                            </h3>
                            <p class="text-gray-600 mt-2 text-sm">
                                {{ trans('inventory::general.pot_text.create_transfer_desc') }}
                            </p>
                            <div class="mt-6 flex items-center text-blue-600 font-medium">
                                <span>{{ trans('general.create') }}</span>
                                <i class="fa fa-arrow-right ml-2"></i>
                            </div>
                        </div>

                        <!-- Icon Column (Right) -->
                        <div class="col-span-1 pot-lottie-trigger cursor-pointer h-40 flex items-center justify-center" id="lottie-transfer">
                            <!-- Lottie will be rendered here -->
                        </div>
                    </div>
                </div>
            </a>

            <!-- Create Return Transfer -->
            <a href="{{ route('inventory.pot.create', ['flow' => 'return']) }}" class="group row-span-1 row-start-2 md:row-span-1 md:row-start-1">
                <div class="p-8 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 border-r-4 border-r-amber-500 h-full">
                    <!-- Grid: 1fr icon, 2fr content -->
                    <div class="grid grid-cols-3 gap-6 items-center h-full">
                        <!-- Icon Column (Left) -->
                        <div class="col-span-1 pot-lottie-trigger cursor-pointer h-40 flex items-center justify-center" id="lottie-return">
                            <!-- Lottie will be rendered here -->
                        </div>

                        <!-- Content Column -->
                        <div class="col-span-2 text-right">
                            <h3 class="text-xl font-semibold text-gray-800 group-hover:text-amber-600 transition-colors">
                                {{ trans('inventory::general.pot_text.create_return') }}
                            </h3>
                            <p class="text-gray-600 mt-2 text-sm">
                                {{ trans('inventory::general.pot_text.create_return_desc') }}
                            </p>
                            <div class="mt-6 flex justify-end text-amber-600 font-medium">
                                <span>{{ trans('general.create') }}</span>
                                <i class="fa fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <script>
            // Lottie animation data
            const lottieData = {
                "nm":"Main Scene","ddd":0,"h":500,"w":500,"meta":{"g":"@lottiefiles/creator 1.69.2"},"layers":[{"ty":4,"nm":"hand 3","sr":1,"st":0,"op":90,"ip":0,"hd":false,"ddd":0,"bm":0,"hasMask":false,"ao":0,"ks":{"a":{"a":0,"k":[0,0,0],"ix":1},"s":{"a":0,"k":[69,69,100],"ix":6},"sk":{"a":0,"k":0},"p":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[244.5,251,0],"t":0,"ti":[0,0,0],"to":[0,0,0]},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[244.5,251,0],"t":34,"ti":[0,0,0],"to":[1,-1,0]},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[250.5,245,0],"t":57,"ti":[1,-1,0],"to":[0,0,0]},{"s":[244.5,251,0],"t":88}],"ix":2},"r":{"a":0,"k":0,"ix":10},"sa":{"a":0,"k":0},"o":{"a":0,"k":100,"ix":11}},"shapes":[{"ty":"gr","bm":0,"hd":false,"mn":"ADBE Vector Group","nm":"Ã¥Â½Â¢Ã§ÂÂ¶ 1","ix":1,"cix":2,"np":3,"it":[{"ty":"sh","bm":0,"hd":false,"mn":"ADBE Vector Shape - Group","nm":"Ã¨Â·Â¯Ã¥Â¾Â 1","ix":1,"d":1,"ks":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[{"c":true,"i":[[10.642,-2.407],[0,0],[0,0],[1.798,1.259],[5.933,-5.933],[0,0],[-5.034,-5.034],[-4.675,0],[-6.832,0.719],[0,0],[-7.552,3.956],[-1.735,5.007],[0,0],[0,0],[5.034,5.394],[3.596,1.079],[0,0],[0,0],[0,0]],"o":[[-9.18,2.076],[0,0],[0,0],[-1.798,-1.259],[-5.933,5.933],[0,0],[5.034,5.034],[4.675,0],[6.832,-0.719],[0,0],[7.552,-3.956],[0.79,-2.279],[0,0],[0,0],[-5.034,-5.394],[-3.596,-1.079],[0,0],[0,0],[0,0]],"v":[[5.3,-16.796],[-4.409,-7.087],[6.379,77.779],[-10.702,67.89],[-25.625,70.587],[-26.704,85.33],[2.783,117.694],[18.965,124.167],[42.339,123.088],[64.634,121.29],[79.737,117.335],[93.402,101.153],[94.481,94.68],[93.042,65.193],[85.131,47.932],[64.275,34.627],[57.802,33.908],[27.96,38.876],[19.684,-8.166]]}],"t":0},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[{"c":true,"i":[[9.35,-1.079],[0,0],[0,0],[1.798,1.259],[5.933,-5.933],[0,0],[-5.034,-5.034],[-4.675,0],[-6.832,0.719],[0,0],[-7.552,3.956],[-1.079,2.158],[0,0],[0,0],[5.034,5.394],[3.596,1.079],[0,0],[0,0],[0,0]],"o":[[-9.35,1.079],[0,0],[0,0],[-1.798,-1.259],[-5.933,5.933],[0,0],[5.034,5.034],[4.675,0],[6.832,-0.719],[0,0],[7.552,-3.956],[1.079,-2.158],[0,0],[0,0],[-5.034,-5.394],[-3.596,-1.079],[0,0],[0,0],[0,0]],"v":[[-0.134,-6.651],[-10.568,5.232],[6.379,77.779],[-7.803,68.252],[-22.727,70.949],[-23.805,85.693],[2.783,117.694],[18.965,124.167],[42.339,123.088],[64.634,121.29],[79.737,117.335],[93.402,101.153],[94.481,94.68],[93.042,65.193],[85.131,47.932],[64.275,34.627],[52.005,33.183],[27.236,38.009],[14.25,1.979]]}],"t":9},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[{"c":true,"i":[[9.35,-1.079],[0,0],[0,0],[1.798,1.259],[5.933,-5.933],[0,0],[-5.034,-5.034],[-4.675,0],[-6.832,0.719],[0,0],[-7.552,3.956],[-1.079,2.158],[0,0],[0,0],[5.034,5.394],[3.596,1.079],[0,0],[0,0],[0,0]],"o":[[-9.35,1.079],[0,0],[0,0],[-1.798,-1.259],[-5.933,5.933],[0,0],[5.034,5.034],[4.675,0],[6.832,-0.719],[0,0],[7.552,-3.956],[1.079,-2.158],[0,0],[0,0],[-5.034,-5.394],[-3.596,-1.079],[0,0],[0,0],[0,0]],"v":[[-0.134,-6.651],[-10.568,5.232],[6.379,77.779],[-7.803,68.252],[-22.727,70.949],[-23.805,85.693],[2.783,117.694],[18.965,124.167],[42.339,123.088],[64.634,121.29],[79.737,117.335],[93.402,101.153],[94.481,94.68],[93.042,65.193],[85.131,47.932],[64.275,34.627],[52.005,33.183],[27.236,38.009],[14.25,1.979]]}],"t":21},{"s":[{"c":true,"i":[[10.642,-2.407],[0,0],[0,0],[1.798,1.259],[5.933,-5.933],[0,0],[-5.034,-5.034],[-4.675,0],[-6.832,0.719],[0,0],[-7.552,3.956],[-1.735,5.007],[0,0],[0,0],[5.034,5.394],[3.596,1.079],[0,0],[0,0],[0,0]],"o":[[-9.18,2.076],[0,0],[0,0],[-1.798,-1.259],[-5.933,5.933],[0,0],[5.034,5.034],[4.675,0],[6.832,-0.719],[0,0],[7.552,-3.956],[0.79,-2.279],[0,0],[0,0],[-5.034,-5.394],[-3.596,-1.079],[0,0],[0,0],[0,0]],"v":[[5.3,-16.796],[-4.409,-7.087],[6.379,77.779],[-10.702,67.89],[-25.625,70.587],[-26.704,85.33],[2.783,117.694],[18.965,124.167],[42.339,123.088],[64.634,121.29],[79.737,117.335],[93.402,101.153],[94.481,94.68],[93.042,65.193],[85.131,47.932],[64.275,34.627],[57.802,33.908],[27.96,38.876],[19.684,-8.166]]}],"t":28}],"ix":2}},{"ty":"st","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Stroke","nm":"Ã¦ÂÂÃ¨Â¾Â¹ 2","lc":1,"lj":1,"ml":4,"o":{"a":0,"k":80,"ix":4},"w":{"a":0,"k":5,"ix":5},"c":{"a":0,"k":[0,0,0],"ix":3}},{"ty":"fl","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Fill","nm":"Ã¥Â¡Â«Ã¥ÂÂ 1","c":{"a":0,"k":[1,1,1],"ix":4},"r":1,"o":{"a":0,"k":80,"ix":5}},{"ty":"tr","a":{"a":0,"k":[0,0],"ix":1},"s":{"a":0,"k":[100,100],"ix":3},"sk":{"a":0,"k":0,"ix":4},"p":{"a":0,"k":[0,0],"ix":2},"r":{"a":0,"k":0,"ix":6},"sa":{"a":0,"k":0,"ix":5},"o":{"a":0,"k":100,"ix":7}}]}],"ind":1},{"ty":4,"nm":"bubble","sr":1,"st":0,"op":90,"ip":0,"hd":false,"ddd":0,"bm":0,"hasMask":false,"ao":0,"ks":{"a":{"a":0,"k":[0,0,0],"ix":1},"s":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[100,100,100],"t":0},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[100,100,100],"t":8},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[95,95,100],"t":10},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[95,95,100],"t":21},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[70,70,100],"t":28},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[100,100,100],"t":35},{"s":[200,200,100],"t":50}],"ix":6},"sk":{"a":0,"k":0},"p":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[250,253,0],"t":0,"ti":[0.667,0.167,0],"to":[-0.667,-0.167,0]},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[246,252,0],"t":9,"ti":[0,0,0],"to":[0,0,0]},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[246,252,0],"t":21,"ti":[-0.667,-0.167,0],"to":[0.667,0.167,0]},{"s":[250,253,0],"t":28}],"ix":2},"r":{"a":0,"k":0,"ix":10},"sa":{"a":0,"k":0},"o":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[70],"t":0},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[60],"t":9},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[60],"t":11},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[60],"t":21},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[0],"t":28},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[60],"t":35},{"s":[0],"t":50}],"ix":11}},"shapes":[{"ty":"gr","bm":0,"hd":false,"mn":"ADBE Vector Group","nm":"bubble-inner","ix":1,"cix":2,"np":3,"it":[{"ty":"el","bm":0,"hd":false,"mn":"ADBE Vector Shape - Ellipse","nm":"circle","d":1,"p":{"a":0,"k":[0,0],"ix":3},"s":{"a":0,"k":[68,68],"ix":2}},{"ty":"st","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Stroke","nm":"Ã¦ÂÂÃ¨Â¾Â¹ 1","lc":1,"lj":1,"ml":4,"o":{"a":0,"k":100,"ix":4},"w":{"a":0,"k":5,"ix":5},"c":{"a":0,"k":[0.0039,0.5176,1],"ix":3}},{"ty":"fl","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Fill","nm":"Ã¥Â¡Â«Ã¥ÂÂ 1","c":{"a":0,"k":[0.0784,0.5137,1],"ix":4},"r":1,"o":{"a":0,"k":80,"ix":5}},{"ty":"tr","a":{"a":0,"k":[0,0],"ix":1},"s":{"a":0,"k":[100,100],"ix":3},"sk":{"a":0,"k":0,"ix":4},"p":{"a":0,"k":[-0.555,-1.422],"ix":2},"r":{"a":0,"k":0,"ix":6},"sa":{"a":0,"k":0,"ix":5},"o":{"a":0,"k":100,"ix":7}}]}],"ind":2},{"ty":4,"nm":"o 5","sr":1,"st":0,"op":90,"ip":0,"hd":false,"ddd":0,"bm":0,"hasMask":false,"ao":0,"ks":{"a":{"a":0,"k":[6.02,-12.121,0],"ix":1},"s":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[60,60,100],"t":50},{"s":[200,200,100],"t":83}],"ix":6},"sk":{"a":0,"k":0},"p":{"a":0,"k":[249.75,251,0],"ix":2},"r":{"a":0,"k":0,"ix":10},"sa":{"a":0,"k":0},"o":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[0],"t":50},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.542},"s":[50],"t":72},{"s":[0],"t":83}],"ix":11}},"shapes":[{"ty":"gr","bm":0,"hd":false,"mn":"ADBE Vector Group","nm":"Ã¦Â¤Â­Ã¥ÂÂ 1","ix":1,"cix":2,"np":3,"it":[{"ty":"el","bm":0,"hd":false,"mn":"ADBE Vector Shape - Ellipse","nm":"Ã¦Â¤Â­Ã¥ÂÂÃ¨Â·Â¯Ã¥Â¾Â 1","d":1,"p":{"a":0,"k":[0,0],"ix":3},"s":{"a":0,"k":[182.32,182.32],"ix":2}},{"ty":"st","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Stroke","nm":"Ã¦ÂÂÃ¨Â¾Â¹ 1","lc":1,"lj":1,"ml":4,"o":{"a":0,"k":50,"ix":4},"w":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[30],"t":50},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[8],"t":72},{"s":[4],"t":83}],"ix":5},"c":{"a":0,"k":[0.0902,0.5255,1],"ix":3}},{"ty":"fl","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Fill","nm":"Ã¥Â¡Â«Ã¥ÂÂ 1","c":{"a":0,"k":[0.1137,0.4667,1],"ix":4},"r":1,"o":{"a":0,"k":0,"ix":5}},{"ty":"tr","a":{"a":0,"k":[0,0],"ix":1},"s":{"a":0,"k":[74.988,74.988],"ix":3},"sk":{"a":0,"k":0,"ix":4},"p":{"a":0,"k":[6.02,-12.121],"ix":2},"r":{"a":0,"k":0,"ix":6},"sa":{"a":0,"k":0,"ix":5},"o":{"a":0,"k":100,"ix":7}}]}],"ind":3},{"ty":4,"nm":"o 4","sr":1,"st":0,"op":90,"ip":0,"hd":false,"ddd":0,"bm":0,"hasMask":false,"ao":0,"ks":{"a":{"a":0,"k":[6.02,-12.121,0],"ix":1},"s":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[60,60,100],"t":39},{"s":[200,200,100],"t":68}],"ix":6},"sk":{"a":0,"k":0},"p":{"a":0,"k":[249.75,251,0],"ix":2},"r":{"a":0,"k":0,"ix":10},"sa":{"a":0,"k":0},"o":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[0],"t":39},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.583},"s":[50],"t":58},{"s":[0],"t":68}],"ix":11}},"shapes":[{"ty":"gr","bm":0,"hd":false,"mn":"ADBE Vector Group","nm":"Ã¦Â¤Â­Ã¥ÂÂ 1","ix":1,"cix":2,"np":3,"it":[{"ty":"el","bm":0,"hd":false,"mn":"ADBE Vector Shape - Ellipse","nm":"Ã¦Â¤Â­Ã¥ÂÂÃ¨Â·Â¯Ã¥Â¾Â 1","d":1,"p":{"a":0,"k":[0,0],"ix":3},"s":{"a":0,"k":[182.32,182.32],"ix":2}},{"ty":"st","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Stroke","nm":"Ã¦ÂÂÃ¨Â¾Â¹ 1","lc":1,"lj":1,"ml":4,"o":{"a":0,"k":50,"ix":4},"w":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[30],"t":39},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[8],"t":58},{"s":[4],"t":68}],"ix":5},"c":{"a":0,"k":[0.0902,0.5255,1],"ix":3}},{"ty":"fl","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Fill","nm":"Ã¥Â¡Â«Ã¥ÂÂ 1","c":{"a":0,"k":[0.1137,0.4667,1],"ix":4},"r":1,"o":{"a":0,"k":0,"ix":5}},{"ty":"tr","a":{"a":0,"k":[0,0],"ix":1},"s":{"a":0,"k":[74.988,74.988],"ix":3},"sk":{"a":0,"k":0,"ix":4},"p":{"a":0,"k":[6.02,-12.121],"ix":2},"r":{"a":0,"k":0,"ix":6},"sa":{"a":0,"k":0,"ix":5},"o":{"a":0,"k":100,"ix":7}}]}],"ind":4},{"ty":4,"nm":"o 3","sr":1,"st":0,"op":90,"ip":0,"hd":false,"ddd":0,"bm":0,"hasMask":false,"ao":0,"ks":{"a":{"a":0,"k":[6.02,-12.121,0],"ix":1},"s":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[60,60,100],"t":26},{"s":[200,200,100],"t":58}],"ix":6},"sk":{"a":0,"k":0},"p":{"a":0,"k":[249.75,251,0],"ix":2},"r":{"a":0,"k":0,"ix":10},"sa":{"a":0,"k":0},"o":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[0],"t":26},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.458},"s":[50],"t":45},{"s":[0],"t":58}],"ix":11}},"shapes":[{"ty":"gr","bm":0,"hd":false,"mn":"ADBE Vector Group","nm":"Ã¦Â¤Â­Ã¥ÂÂ 1","ix":1,"cix":2,"np":3,"it":[{"ty":"el","bm":0,"hd":false,"mn":"ADBE Vector Shape - Ellipse","nm":"Ã¦Â¤Â­Ã¥ÂÂÃ¨Â·Â¯Ã¥Â¾Â 1","d":1,"p":{"a":0,"k":[0,0],"ix":3},"s":{"a":0,"k":[182.32,182.32],"ix":2}},{"ty":"st","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Stroke","nm":"Ã¦ÂÂÃ¨Â¾Â¹ 1","lc":1,"lj":1,"ml":4,"o":{"a":0,"k":50,"ix":4},"w":{"a":1,"k":[{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.833},"s":[30],"t":26},{"o":{"x":0.167,"y":0.167},"i":{"x":0.833,"y":0.458},"s":[8],"t":45},{"s":[4],"t":58}],"ix":5},"c":{"a":0,"k":[0.0902,0.5255,1],"ix":3}},{"ty":"fl","bm":0,"hd":false,"mn":"ADBE Vector Graphic - Fill","nm":"Ã¥Â¡Â«Ã¥ÂÂ 1","c":{"a":0,"k":[0.1137,0.4667,1],"ix":4},"r":1,"o":{"a":0,"k":0,"ix":5}},{"ty":"tr","a":{"a":0,"k":[0,0],"ix":1},"s":{"a":0,"k":[74.988,74.988],"ix":3},"sk":{"a":0,"k":0,"ix":4},"p":{"a":0,"k":[6.02,-12.121],"ix":2},"r":{"a":0,"k":0,"ix":6},"sa":{"a":0,"k":0,"ix":5},"o":{"a":0,"k":100,"ix":7}}]}],"ind":5}],"v":"5.7.0","fr":60,"op":90,"ip":0,"assets":[]
            };

            // Initialize Lottie animations
            let transferAnimation, returnAnimation;

            function initLottieAnimations() {
                transferAnimation = lottie.loadAnimation({
                    container: document.getElementById('lottie-transfer'),
                    renderer: 'svg',
                    loop: false,
                    autoplay: false,
                    animationData: lottieData
                });

                returnAnimation = lottie.loadAnimation({
                    container: document.getElementById('lottie-return'),
                    renderer: 'svg',
                    loop: false,
                    autoplay: false,
                    animationData: lottieData
                });

                // Add event listeners to trigger animation on hover and touch
                attachAnimationTriggers();
            }

            function attachAnimationTriggers() {
                const triggers = document.querySelectorAll('.pot-lottie-trigger');

                triggers.forEach((trigger, index) => {
                    const animation = index === 0 ? transferAnimation : returnAnimation;

                    // Hover event
                    trigger.addEventListener('mouseenter', () => {
                        animation.goToAndPlay(0, true);
                    });

                    // Touch event
                    trigger.addEventListener('touchstart', () => {
                        animation.goToAndPlay(0, true);
                    });
                });
            }

            // Initialize when DOM is ready
            document.addEventListener('DOMContentLoaded', initLottieAnimations);
        </script>
    </x-slot>
</x-layouts.admin>
