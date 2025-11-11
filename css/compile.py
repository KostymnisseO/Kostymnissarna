from os import scandir, path
from datetime import datetime

out_filename = 'style.css'
out_dir = '../'

with open(out_dir+out_filename, 'w') as out_file:
    compiled_files={}
    
    with scandir('.') as folder:
        for entry in folder:
            if (entry.is_file()
                and entry.name.endswith(".css")
                and entry.name != out_filename):
                compiled_files[entry.name] = entry

        compiled_files = dict(sorted(compiled_files.items())).values()

    print("\nCompiling files:")       
    for file in compiled_files:
        print("+ " + file.name)
        with open(file.name, 'r') as in_file:
            out_file.write(f"/* \t{file.name.upper()} */" + "\n")
            out_file.write(in_file.read())
            out_file.write(f"\n\n")
                
    print(f"\nDone. [{datetime.now().strftime("%H:%M:%S")}]\n")
    
print(f"\nOutput file: {out_dir}{out_filename}\n")
