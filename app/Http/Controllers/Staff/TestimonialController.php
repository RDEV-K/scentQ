<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $testimonials = Testimonial::oldest('index')->paginate(20);

        return view('staff.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('staff.testimonial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);

        Testimonial::create([
            'video_url' => $request->url,
        ]);

        return redirect()->route('staff.testimonial.index');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('staff.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'url' => 'required'
        ]);

        $testimonial->update([
            'video_url' => $request->url,
        ]);

        return redirect()->route('staff.testimonial.index');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('staff.testimonial.index');
    }

    public function sorting(Request $request)
    {
        try {
            $testimonials = Testimonial::all();

            foreach ($testimonials as $testimonial) {
                $testimonial->timestamps = false;
                $id = $testimonial->id;

                foreach ($request->order as $order) {
                    if ($order['id'] == $id) {
                        $testimonial->update(['index' => $order['position']]);
                    }
                }
            }

            return response()->json(['message' => 'Custom Field Sorted Successfully!']);
        } catch (\Throwable $th) {

            return back();
        }
    }
}
