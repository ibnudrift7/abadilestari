<?php 
// function get database $dbcon
// mysql_connect($dbcon['host'], $dbcon['user'], $dbcon['pass']);
// mysql_select_db($dbcon['db']);

    function getRandom()
    {
        $randm = 'rand-'.rand(1000,9999);
        return $randm;
    }

    $set_random = getRandom();
    

    $data_facilities = [
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Raw Material Cold Storage',
                                'titles_ch' => '低温存料间',
    							'desc' => 'PT. Abadi Lestari made sure all raw materials stored into the cold storage to ensure it’s quality preserved before it goes to the washing and cleaning process.',
                                'desc_ch' => 'Abadi Lestari Indonesia 有限公司为了确保原料的质量，进入洗涤和清洁过程之间，所有的原料要存在气温存料间',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Washing & Cleaning Room',
                                'titles_ch' => '洗涤与清洁间',
    							'desc' => 'This is the area where most of all our trained human resources do the hard part of cleaning all unwanted materials from the Swallow bird’s nest.',
                                'desc_ch' => '在此过程，所有的人力资源做最难的任务，是把在燕窝中不需的物质丢掉',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Inspection Room',
                                'titles_ch' => '检验间',
    							'desc' => 'In the inspection room, cleaned bird’s nest will be double checked and sorted whether it needs further cleaning or continue to the next process.',
                                'desc_ch' => '在检验间里，已合格清洁过程的燕窝进行检查并分出来哪个燕窝需要再清洁或是可以继续下一步过程。',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Dry Room',
                                'titles_ch' => '干性间',
    							'desc' => 'PT. Abadi Lestari put the processed bird’s nests to the dry room to reduce its’ humidity and ensuring it’s preservation. ',
                                'desc_ch' => '有限公司把已合格的燕窝存在干性间，这是为了减少其湿度及确保保存。',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Packing Room',
                                'titles_ch' => '包装间',
    							'desc' => 'All of our clean processed bird’s nest will go to the packing room for last quality checking before packed and stored for delivery.',
                                'desc_ch' => '包装与发货之前，所有的燕窝将进入到包装间进行最后的质量检验。',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'End Product Cold Storage',
                                'titles_ch' => '低温存品间',
    							'desc' => 'PT. Abadi Lestari stored the processed end products at a different cold storage room, separate from the raw material storage room.',
                                'desc_ch' => '有限公司把最终燕窝产品存在不同的低温存品间，占用的地方与低温存料间分开储存。',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Storage of Process Materials',
                                'titles_ch' => '用料储存',
    							'desc' => 'PT. Abadi Lestari organised process materials neatly and following the best standard operating procedure.',
                                'desc_ch' => '有限公司把用料仔细地管理以及按最好的标准操作规程',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Machinery and Equipment',
                                'titles_ch' => '机器及设备',
    							'desc' => 'From cleaning equipment, dryers, heaters and vaccum or non vacuum packers.',
                                'desc_ch' => '使用最新最有现代化的清洁设备、烘燥机器及真或不真空包装设备',
    						],
    						[
    							'pict' => 'dt-facility-1.jpg',
    							'titles' => 'Other Equipments',
                                'titles_ch' => '其他设备',
    							'desc' => 'Such as product packaging checkers, metal detectors, carrying & transporting tools.',
                                'desc_ch' => '如包装检查器、金属探测器和运输工具',
    						],
    						
    					];

        $data_facilities = array_chunk($data_facilities, 2);