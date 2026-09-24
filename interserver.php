<?php
declare(strict_types=1);

final class InterServerAPI {
    private SoapClient $client;
    private string $sid;

    public function __construct(?string $apiKey=null, ?string $username=null) {
        if(!class_exists('SoapClient')) throw new RuntimeException('PHP SOAP extension is required.');
        $apiKey=$apiKey ?: (string)(cfg('interserver.api_key','') ?: getenv('INTERSERVER_API_KEY'));
        $username=$username ?: (string)(cfg('interserver.username','') ?: getenv('INTERSERVER_USERNAME'));
        if($apiKey==='') throw new RuntimeException('InterServer API key is not configured.');
        if($username==='') throw new RuntimeException('InterServer account email/username is required by the SOAP API.');
        $this->client=new SoapClient((string)cfg('interserver.wsdl','https://my.interserver.net/api.php?wsdl'),[
            'cache_wsdl'=>WSDL_CACHE_BOTH,'connection_timeout'=>15,'exceptions'=>true,'trace'=>false,
        ]);
        $sid=$this->client->api_login($username,$apiKey);
        if(!is_string($sid) || $sid==='') throw new RuntimeException('InterServer authentication failed.');
        $this->sid=$sid;
    }

    public function call(string $method,array $args=[]): mixed { return $this->client->__soapCall($method,$args); }

    public function vpsProducts(float $markup=1.0): array {
        $rows=$this->call('get_vps_slice_types'); $rows=is_array($rows)?$rows:[]; $out=[];
        foreach($rows as $row){ $a=(array)$row; $cost=(float)($a['cost']??0); if($cost<=0 || !(int)($a['buyable']??0)) continue;
            $out[]=['id'=>'vps:'.(int)$a['type'],'category'=>'vps','name'=>(string)($a['name']??'VPS'),'cost'=>round($cost+$markup,2),'provider_cost'=>$cost,'period'=>'month','type'=>(int)$a['type']]; }
        return $out;
    }

    public function licenseProducts(float $markup=1.0): array {
        $rows=$this->call('api_get_license_types'); $rows=is_array($rows)?$rows:[]; $out=[];
        foreach($rows as $row){ $a=(array)$row; $cost=(float)($a['cost']??$a['services_cost']??0); $id=(int)($a['id']??$a['services_id']??0);
            if($cost<=0 || !$id) continue;
            $out[]=['id'=>'license:'.$id,'category'=>'license','name'=>(string)($a['name']??$a['services_name']??'License'),'cost'=>round($cost+$markup,2),'provider_cost'=>$cost,'period'=>'month','type'=>$id]; }
        return $out;
    }

    public function products(float $markup=1.0): array { return array_merge($this->vpsProducts($markup),$this->licenseProducts($markup)); }

    public function buyVps(array $p): array {
        $res=$this->call('api_api_buy_vps',[
            $this->sid,(string)$p['os'],(int)$p['slices'],(string)$p['platform'],(string)($p['controlpanel']??''),
            (int)($p['period']??1),(int)$p['location'],(string)$p['version'],(string)$p['hostname'],
            (string)($p['coupon']??''),(string)$p['rootpass'],(string)($p['comment']??''),(bool)($p['ipv6only']??false)
        ]); return (array)$res;
    }
}

function oxb_interserver_products(InterServerAPI $api,float $markup=1.0): array { return $api->products($markup); }
