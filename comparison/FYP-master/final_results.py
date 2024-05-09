from music21 import *
import os, subprocess, json
from compare_notes import sliding_list
from notes_in_measures import notes_by_measure, mapping_to_measures
from ngrams_preprocessing import midi_file_path1_mxl, midi_file_path2


def generate_new_list(tuple_list):
    new_list = []
    for tup in tuple_list:
        if tup[0] == 'Pitch Match':
            if tup[1] == 'Dur. Mismatch':
                new_list.append(tup)
            elif tup[1] == 'Dur. Match':
                new_list.append('Match')
            else:
                new_list.append('Match')
        elif tup[0] == 'Pitch Mismatch':
                new_list.append('No Match')
        elif tup == 'Sliding':
            new_list.append(tup)
        else:
            new_list.append(tup[1])
    return new_list


def write_on_score():
    # Replace 'path_to_your_file.musicxml' with the actual path to your MusicXML file
    score = converter.parse(midi_file_path1_mxl)
    for part in score.parts:
        for measure_number, labels in mapped_measures.items():
            measure = part.measure(measure_number)
            notes = measure.notes
            # Set the color based on the label type
            for label_index, label in enumerate(labels):
                if label_index < len(notes):
                    if isinstance(label, tuple):
                        for index, element in enumerate(label):
                            # For the first element of the tuple, we place it with the default setting
                            notes[label_index].addLyric(label[index])
                            if element == 'No Match' or element == 'Dur. Mismatch' or element == 'Pitch Mismatch':
                                notes[label_index].lyrics[index].style.color = 'red'
                            elif element == 'Sliding':
                                notes[label_index].addLyric(label[index]).style.color = 'yellow'
                            elif element == 'Match' or element == 'Dur. Match' or element == 'Pitch Match':
                                notes[label_index].lyrics[index].style.color = 'green'
                            else:
                                # Default color
                                notes[label_index].lyrics[index].style.color = 'black'
                        # For the second element of the tuple, we specify it to be in a different verse
                        # by incrementing the number
                    else:
                        notes[label_index].addLyric(label)
                        if label == 'No Match' or label == 'Dur. Mismatch' or label == 'Pitch Mismatch':
                            notes[label_index].lyrics[-1].style.color = 'red'
                        elif label == 'Sliding':
                            notes[label_index].lyrics[-1].style.color = 'yellow'
                        elif label == 'Match' or label == 'Dur. Match' or label == 'Pitch Match':
                            notes[label_index].lyrics[-1].style.color = 'green'
                        else:
                            # Default color
                            notes[label_index].lyrics[-1].style.color = 'black'

    # Get the base name of the original MusicXML file
    base_name = os.path.splitext(os.path.basename(midi_file_path1_mxl))[0]
    base_name2 = os.path.splitext(os.path.basename(midi_file_path2))[0]

    # Compose the output file name with 'modified' appended
    output_file_name = base_name + '_modified.xml'
    print(os.getcwd())

    # Specify the output file path in the "Test Files" directory
    output_file_path_xml = os.path.join('Test Files', output_file_name)

    # Write the modified score to the output file
    score.write('musicxml', output_file_path_xml)

    # Construct the output PNG file path using base_name
    output_file_path_png = os.path.join('Images', base_name + '.png')
    output_file_path2_png = os.path.join('Images', base_name2 + '.png')

    # Run MuseScore command to generate PNG from MusicXML
    command = [
        'C:\\Program Files\\MuseScore 4\\bin\\MuseScore4.exe',  # Path to MuseScore 4 executable
        '-o', output_file_path_png,  # Output PNG file path
        '-r', '300',  # Resolution (dpi)
        output_file_path_xml  # Input and output MusicXML file path (they are the same in this case)
    ]

    command2 = [
        'C:\\Program Files\\MuseScore 4\\bin\\MuseScore4.exe',  # Path to MuseScore 4 executable
        '-o', output_file_path2_png,  # Output PNG file path
        '-r', '300',  # Resolution (dpi)
        midi_file_path2  # Input MusicXML file path
    ]

    # Execute the command
    result = subprocess.run(command)
    result = subprocess.run(command2)

    # Check the exit status
    if result.returncode != 0:
        print(f"Error: Command '{command}' returned non-zero exit status {result.returncode}.")
        print(f"Error: Command '{command2}' returned non-zero exit status {result.returncode}.")

def compute_pitch_score(tuple_list):
    pitch_counter = 0

    total_tuples = len(tuple_list)

    for item in tuple_list:
        if isinstance(item, tuple):

            if item[0] == 'Pitch Match' or item[0] == 'Match':
                pitch_counter += 1

        elif item == 'Match':
            pitch_counter += 1

    if total_tuples == 0:
        return 0  # Avoid division by zero

    score = pitch_counter / total_tuples
    return score*80


def compute_duration_score(tuple_list):
    match_counter = 0
    pitch_match_counter = 0

    for item in tuple_list:
        if isinstance(item, tuple) and item[0] == 'Pitch Match':
            pitch_match_counter += 1

        elif item == 'Match':
            match_counter += 1
            pitch_match_counter += 1

    if pitch_match_counter == 0:
        return 0  # Avoid division by zero

    score = match_counter / pitch_match_counter
    return score*10

def compute_sliding_score(tuple_list):
    sliding_counter = len(tuple_list)

    total_tuples = len(tuple_list)

    for item in tuple_list:

        if item == 'Sliding':
            sliding_counter -= 1

    if total_tuples == 0:
        return 0  # Avoid division by zero

    score = sliding_counter / total_tuples
    return score*10

def compute_total_score(tuple_list):
    return compute_pitch_score(tuple_list)+compute_duration_score(tuple_list)+compute_sliding_score(tuple_list)

#result_sliding = sliding()

# Combine the results in the requested format
#combined_results = list(zip(result_sliding, sliding_list))


print("_______________")

new_list = generate_new_list(sliding_list)
print("new list", new_list)

print("_______________")


mapped_measures = mapping_to_measures(notes_by_measure, new_list)

# Write mapped measures to output.txt
for measure, notes in mapped_measures.items():
    print(f"{measure}: {notes}")


write_on_score()

print(compute_pitch_score(new_list))
print(compute_duration_score(new_list))
print(compute_sliding_score(new_list))

total_score = compute_total_score(new_list)
print('Total score: ', format(total_score, ".2f"), "/ 100")


# Load existing data from the JSON file if it exists
try:
    with open("results.json", "r") as json_file:
        data_list = json.load(json_file)
except FileNotFoundError:
    # If the file doesn't exist yet, initialize an empty list
    data_list = []

# Add new data to the list
data = {'score': total_score, 'list': new_list}
data_list.append(data)

# Dump the updated data list into the JSON file
with open("results.json", "w") as json_file:
    json.dump(data_list, json_file)


