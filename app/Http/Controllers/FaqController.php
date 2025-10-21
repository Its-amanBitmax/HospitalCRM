<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.faq');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faq_id' => 'required|integer|unique:faqs,faq_id',
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:Active,Inactive',
        ]);

        Faq::create([
            'faq_id' => $request->faq_id,
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'FAQ added successfully']);
    }

    public function getFaqs()
    {
        $faqs = Faq::all();
        return response()->json($faqs);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'faq_id' => 'required|integer|unique:faqs,faq_id,' . $id,
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:Active,Inactive',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'faq_id' => $request->faq_id,
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'FAQ updated successfully']);
    }

    public function delete($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
