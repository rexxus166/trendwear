<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    private $apiKeys = [
        "AIzaSyAZ-1PINf7zv8RR9LfuvREq1t3Z0R5oIBU",
        "AIzaSyAaD38Fz8hcP7MYRlhpy45ubBwF9_pTmps",
        "AIzaSyD_sq7k1Si68x4HonDJs6-rrQJJFc1oNv0",
        "AIzaSyARQOcIifgG0flYkVItOjxVfh_PNT_J2x0",
        "AIzaSyCH6ec7JkB02saHF8tDhJUhcgSJ9Ix88JY",
        "AIzaSyBi72slFExT06xXC55_CUWGSgJUiLR6wIg"
    ];

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        // 1. Retrieve Product Context
        $products = Product::where('status', 'active')
            ->with('category') // Eager load category
            ->get();

        $productContext = "Catalog Data:\n";
        foreach ($products as $product) {
            $categoryName = $product->category ? $product->category->name : 'Uncategorized';
            $productContext .= "- Category: {$categoryName}\n";
            $productContext .= "  Name: {$product->name}\n";
            $productContext .= "  Price: Rp " . number_format($product->price, 0, ',', '.') . "\n";
            $productContext .= "  Stock: {$product->stock}\n";
            $productContext .= "  Description: " . strip_tags($product->description) . "\n";
            if ($product->sizes) $productContext .= "  Sizes: " . implode(', ', $product->sizes) . "\n";
            if ($product->colors) $productContext .= "  Colors: " . implode(', ', $product->colors) . "\n";
            $productContext .= "\n";
        }

        if ($products->isEmpty()) {
            $productContext = "Catalog is currently empty. Politely inform the user that no products are available at the moment.";
        }

        $systemDetail = "You are TrendAi, an intelligent personal shopper assistant for TrendWear. 
        Your goal is to help customers find products from the provided catalog ONLY.
        
        INTERACTION FLOW:
        1. If the user asks broadly 'what products do you have?' or 'ada produk apa?':
           - Do NOT list all products immediately.
           - Instead, mention the available CATEGORIES based on the products (e.g., Streetwear, Casual, Accessories).
           - Ask the user: 'Mau lihat produk dari kategori apa? (Streetwear, Casual, atau Accessories?)'
        2. If the user selects a category, THEN list the products in that category.
        3. If the user asks for a specific item (e.g. 'ada jaket?'), answer directly.

        STRICT RULES:
        1. ONLY recommend products listed in the 'Catalog Data' below. Do NOT invent or hallucinate products.
        2. Do NOT use markdown formatting like bold (**text**) or italics (*text*). Use plain text only.
        3. Keep answers concise and readable in Bahasa Indonesia.
        4. Be polite and helpful.";

        // Construct Conversation for Gemini
        $contents = [];

        // System Prompt (Passed as context in first user message if possible, or mixed in)
        // Gemini Flash works best with System Instruction, but here manually effectively works:
        $contents[] = [
            "role" => "user",
            "parts" => [
                ["text" => $systemDetail . "\n\n" . $productContext . "\n\n(Acknowledge this context and be ready)"]
            ]
        ];

        $contents[] = [
            "role" => "model",
            "parts" => [
                ["text" => "Dimengerti. Saya TrendAi dan saya siap membantu pelanggan menemukan produk dari katalog yang diberikan."]
            ]
        ];

        // Append User History
        foreach ($history as $msg) {
            // Map 'ai' role from frontend to 'model' for Gemini
            $role = ($msg['role'] === 'ai') ? 'model' : 'user';

            // Clean text to avoid array errors
            $text = "";
            if (isset($msg['parts'][0]['text'])) {
                $text = $msg['parts'][0]['text'];
            } elseif (isset($msg['text'])) {
                $text = $msg['text'];
            } elseif (is_string($msg['parts'][0])) {
                $text = $msg['parts'][0];
            }

            if (!empty($text)) {
                $contents[] = [
                    "role" => $role,
                    "parts" => [
                        ["text" => $text]
                    ]
                ];
            }
        }

        // Add Current Message
        $contents[] = [
            "role" => "user",
            "parts" => [
                ["text" => $userMessage]
            ]
        ];

        // 3. Call Gemini API
        $response = $this->callGemini($contents);

        if ($response) {
            return response()->json([
                'status' => 'success',
                'reply' => $response
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'AI is currently unavailable. Please try again later.'
            ], 503);
        }
    }

    private function callGemini($contents)
    {
        foreach ($this->apiKeys as $key) {
            try {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$key}";

                $response = Http::withoutVerifying()
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($url, [
                        "contents" => $contents
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
                        return $json['candidates'][0]['content']['parts'][0]['text'];
                    }
                } else {
                    Log::error("Gemini API Error [Key: " . substr($key, 0, 8) . "...]: " . $response->body());
                }

                // If we reach here, this key failed or returned unexpected format
                Log::warning("Gemini API Key failed: " . substr($key, 0, 8) . "...");
            } catch (\Exception $e) {
                Log::error("Gemini API Exception: " . $e->getMessage());
                continue; // Try next key
            }
        }

        return null; // All keys failed
    }
}
