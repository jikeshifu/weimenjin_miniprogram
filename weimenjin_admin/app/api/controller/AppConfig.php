<?php

namespace app\api\controller;

class AppConfig extends Common
{
    public function runtime()
    {
        $siteUrl = rtrim((string) config('my.siteconfig.siteurl', ''), '/');
        if ($siteUrl === '') {
            $siteUrl = rtrim((string) request()->domain(), '/');
        }

        $liveTalk = (array) config('my.live_talk', []);
        $miniapp = (array) config('my.miniapp', []);
        $defaultAudioUrl = (string) ($liveTalk['default_audio_url'] ?? '/audio/wmj.mp3');

        return json([
            'status' => $this->successCode,
            'data' => [
                'miniapp' => [
                    'site_url' => (string) ($miniapp['site_url'] ?? $siteUrl),
                    'api_url' => (string) ($miniapp['api_url'] ?? ($siteUrl . '/api')),
                    'asset_url' => (string) ($miniapp['asset_url'] ?? $siteUrl),
                    'camweb_url' => (string) ($miniapp['camweb_url'] ?? ($siteUrl . '/camweb/')),
                ],
                'live_talk' => [
                    'enabled' => (bool) ($liveTalk['enabled'] ?? false),
                    'public_wss_base' => (string) ($liveTalk['public_wss_base'] ?? ''),
                    'app_ws_protocol' => (string) ($liveTalk['app_ws_protocol'] ?? 'wss'),
                    'app_ws_host' => (string) ($liveTalk['app_ws_host'] ?? ''),
                    'app_ws_port' => (string) ($liveTalk['app_ws_port'] ?? ''),
                    'app_ws_path_prefix' => (string) ($liveTalk['app_ws_path_prefix'] ?? '/ws/horn/live/app'),
                    'sample_rate' => (int) ($liveTalk['sample_rate'] ?? 16000),
                    'channels' => (int) ($liveTalk['channels'] ?? 1),
                    'encode_bitrate' => (int) ($liveTalk['encode_bitrate'] ?? 64000),
                    'frame_size_kb' => (int) ($liveTalk['frame_size_kb'] ?? 1),
                    'chunk_delay_ms' => (int) ($liveTalk['chunk_delay_ms'] ?? 40),
                    'max_duration_sec' => (int) ($liveTalk['max_duration_sec'] ?? 90),
                    'app_upload_codec' => (string) ($liveTalk['app_upload_codec'] ?? 'mp3'),
                    'default_audio_url' => $this->normalizeUrl($defaultAudioUrl, $siteUrl),
                ],
            ],
        ]);
    }

    private function normalizeUrl(string $url, string $siteUrl): string
    {
        $url = trim($url);
        if ($url === '') {
            return '';
        }
        if (preg_match('/^https?:\/\//i', $url)) {
            return $url;
        }
        return $siteUrl . '/' . ltrim($url, '/');
    }
}
