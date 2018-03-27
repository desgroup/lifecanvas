<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert(array(
            array('id' => '1', 'country_code' => 'CA', 'province_code' => 'AB', 'province_name_en' => 'Alberta', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '2', 'country_code' => 'CA', 'province_code' => 'BC', 'province_name_en' => 'British Columbia', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '3', 'country_code' => 'CA', 'province_code' => 'MB', 'province_name_en' => 'Manitoba', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '4', 'country_code' => 'CA', 'province_code' => 'NB', 'province_name_en' => 'New Brunswick', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '5', 'country_code' => 'CA', 'province_code' => 'NL', 'province_name_en' => 'Newfoundland', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '6', 'country_code' => 'CA', 'province_code' => 'NS', 'province_name_en' => 'Nova Scotia', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '7', 'country_code' => 'CA', 'province_code' => 'NU', 'province_name_en' => 'Nunavut', 'type' => 'T', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '8', 'country_code' => 'CA', 'province_code' => 'ON', 'province_name_en' => 'Ontario', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '9', 'country_code' => 'CA', 'province_code' => 'PE', 'province_name_en' => 'Prince Edward Island', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '10', 'country_code' => 'CA', 'province_code' => 'QC', 'province_name_en' => 'Quebec', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '11', 'country_code' => 'CA', 'province_code' => 'SK', 'province_name_en' => 'Saskatchewan', 'type' => 'P', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '12', 'country_code' => 'CA', 'province_code' => 'NT', 'province_name_en' => 'Northwest Territories', 'type' => 'T', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '13', 'country_code' => 'CA', 'province_code' => 'YT', 'province_name_en' => 'Yukon Territory', 'type' => 'T', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '14', 'country_code' => 'US', 'province_code' => 'AK', 'province_name_en' => 'Alaska', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '15', 'country_code' => 'US', 'province_code' => 'AL', 'province_name_en' => 'Alabama', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '16', 'country_code' => 'US', 'province_code' => 'AR', 'province_name_en' => 'Arkansas', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '18', 'country_code' => 'US', 'province_code' => 'AZ', 'province_name_en' => 'Arizona', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '19', 'country_code' => 'US', 'province_code' => 'CA', 'province_name_en' => 'California', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '20', 'country_code' => 'US', 'province_code' => 'CO', 'province_name_en' => 'Colorado', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '21', 'country_code' => 'US', 'province_code' => 'CT', 'province_name_en' => 'Connecticut', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '22', 'country_code' => 'US', 'province_code' => 'DC', 'province_name_en' => 'District of Columbia', 'type' => 'D', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '23', 'country_code' => 'US', 'province_code' => 'DE', 'province_name_en' => 'Delaware', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '24', 'country_code' => 'US', 'province_code' => 'FL', 'province_name_en' => 'Florida', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '26', 'country_code' => 'US', 'province_code' => 'GA', 'province_name_en' => 'Georgia', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '28', 'country_code' => 'US', 'province_code' => 'HI', 'province_name_en' => 'Hawaii', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '29', 'country_code' => 'US', 'province_code' => 'IA', 'province_name_en' => 'Iowa', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '30', 'country_code' => 'US', 'province_code' => 'ID', 'province_name_en' => 'Idaho', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '31', 'country_code' => 'US', 'province_code' => 'IL', 'province_name_en' => 'Illinois', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '32', 'country_code' => 'US', 'province_code' => 'IN', 'province_name_en' => 'Indiana', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '33', 'country_code' => 'US', 'province_code' => 'KS', 'province_name_en' => 'Kansas', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '34', 'country_code' => 'US', 'province_code' => 'KY', 'province_name_en' => 'Kentucky', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '35', 'country_code' => 'US', 'province_code' => 'LA', 'province_name_en' => 'Louisiana', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '36', 'country_code' => 'US', 'province_code' => 'MA', 'province_name_en' => 'Massachusetts', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '37', 'country_code' => 'US', 'province_code' => 'MD', 'province_name_en' => 'Maryland', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '38', 'country_code' => 'US', 'province_code' => 'ME', 'province_name_en' => 'Maine', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '40', 'country_code' => 'US', 'province_code' => 'MI', 'province_name_en' => 'Michigan', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '41', 'country_code' => 'US', 'province_code' => 'MN', 'province_name_en' => 'Minnesota', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '42', 'country_code' => 'US', 'province_code' => 'MO', 'province_name_en' => 'Missouri', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '44', 'country_code' => 'US', 'province_code' => 'MS', 'province_name_en' => 'Mississippi', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '45', 'country_code' => 'US', 'province_code' => 'MT', 'province_name_en' => 'Montana', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '46', 'country_code' => 'US', 'province_code' => 'NC', 'province_name_en' => 'North Carolina', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '47', 'country_code' => 'US', 'province_code' => 'ND', 'province_name_en' => 'North Dakota', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '48', 'country_code' => 'US', 'province_code' => 'NE', 'province_name_en' => 'Nebraska', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '49', 'country_code' => 'US', 'province_code' => 'NH', 'province_name_en' => 'New Hampshire', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '50', 'country_code' => 'US', 'province_code' => 'NJ', 'province_name_en' => 'New Jersey', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '51', 'country_code' => 'US', 'province_code' => 'NM', 'province_name_en' => 'New Mexico', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '52', 'country_code' => 'US', 'province_code' => 'NV', 'province_name_en' => 'Nevada', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '53', 'country_code' => 'US', 'province_code' => 'NY', 'province_name_en' => 'New York', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '54', 'country_code' => 'US', 'province_code' => 'OH', 'province_name_en' => 'Ohio', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '55', 'country_code' => 'US', 'province_code' => 'OK', 'province_name_en' => 'Oklahoma', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '56', 'country_code' => 'US', 'province_code' => 'OR', 'province_name_en' => 'Oregon', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '57', 'country_code' => 'US', 'province_code' => 'PA', 'province_name_en' => 'Pennsylvania', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '60', 'country_code' => 'US', 'province_code' => 'RI', 'province_name_en' => 'Rhode Island', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '61', 'country_code' => 'US', 'province_code' => 'SC', 'province_name_en' => 'South Carolina', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '62', 'country_code' => 'US', 'province_code' => 'SD', 'province_name_en' => 'South Dakota', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '63', 'country_code' => 'US', 'province_code' => 'TN', 'province_name_en' => 'Tennessee', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '64', 'country_code' => 'US', 'province_code' => 'TX', 'province_name_en' => 'Texas', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '65', 'country_code' => 'US', 'province_code' => 'UT', 'province_name_en' => 'Utah', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '66', 'country_code' => 'US', 'province_code' => 'VA', 'province_name_en' => 'Virginia', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '68', 'country_code' => 'US', 'province_code' => 'VT', 'province_name_en' => 'Vermont', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '69', 'country_code' => 'US', 'province_code' => 'WA', 'province_name_en' => 'Washington', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '70', 'country_code' => 'US', 'province_code' => 'WV', 'province_name_en' => 'West Virginia', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '71', 'country_code' => 'US', 'province_code' => 'WI', 'province_name_en' => 'Wisconsin', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')),
            array('id' => '72', 'country_code' => 'US', 'province_code' => 'WY', 'province_name_en' => 'Wyoming', 'type' => 'S', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'))
        ));
    }
}
