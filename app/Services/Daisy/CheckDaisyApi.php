<?php

namespace App\Services\Daisy;

/*use App\System;
use Illuminate\Database\Eloquent\Model;

class CheckDaisyApi extends Model
{
    public function call($healt='health')
    {
        $system = System::find(1);
        $daisy = new DaisyIntegration($system);
        return json_decode($daisy->getResource($healt)->getBody()->getContents() , true);
    }


}*/
use App\System;
use RuntimeException;

class DaisyHealthChecker
{
    private DaisyIntegration $daisy;

    public function __construct(DaisyIntegration $daisy)
    {
        $this->daisy = $daisy;
    }

    /**
     * Ping the Daisy API and return the decoded JSON response.
     *
     * @param  string  $endpoint  Path relative to base (default: "health")
     * @return array<string,mixed>
     */
    public function call(string $endpoint = 'health'): array
    {
        try {
            $response = $this->daisy->getResource($endpoint, 'json');
            $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            // Todo: log
            throw new RuntimeException('Failed to reach Daisy API: '.$e->getMessage(), 0, $e);
        }

        return $data;
    }
}
/* Controller
public function health(DaisyHealthChecker $checker)
{
    $data = $checker->call(); // defaults to 'health'
    return response()->json($data);
}*/
