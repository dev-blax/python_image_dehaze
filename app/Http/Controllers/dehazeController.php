<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dehazeController extends Controller
{
    public function store(Request $request){
        //dd($request);

        // Get the uploaded image file from the request
        $image = $request->file('HazeImage');

        // Generate a unique filename for the image
        $filename = uniqid() . '_.' . $image->getClientOriginalExtension();


        // Save the image to the public folder
        $image->move(public_path('images'), $filename);

        // Define the path to the saved image
        $imagePath = 'images/' . $filename;
        //dd($imagePath);

        // Define the command to run the Python script with the image path as an argument
        $pythonCommand = 'python app.py ' . $imagePath;

        // Open a process to run the command asynchronously
        $descriptors = array(
            0 => array('pipe', 'r'), // stdin
            1 => array('pipe', 'w'), // stdout
            2 => array('pipe', 'w'), // stderr
        );
        $process = proc_open($pythonCommand, $descriptors, $pipes);

        // Read the output of the Python script asynchronously
        $output = '';
        while ($pipe = fgets($pipes[1])) {
            $output .= $pipe;
        }

        // Close the process and the pipes
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);


        //dd($output);


        return back()->with('dehazed_path', $output);

    }
}
